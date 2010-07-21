<?php
# Based on:
# PHP Calendar (version 2.3), written by Keith Devens
# http://keithdevens.com/software/php_calendar
#  see example at http://keithdevens.com/weblog
# License: http://keithdevens.com/software/license

function generate_calendar($year, $month, $days = array(), $first_day = 1){
	$first_of_month = gmmktime(0,0,0,$month,1,$year);
	#remember that mktime will automatically correct if invalid dates are entered
	# for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998
	# this provides a built in "rounding" feature to generate_calendar()

	$day_names = array(); #generate all the day names according to the current locale
	for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) #January 4, 1970 was a Sunday
		$day_names[$n] = ucfirst(gmstrftime('%A',$t)); #%A means full textual day name

	list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));
	$weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day
	$title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year;  #note that some locales don't capitalize month and day names

	#Begin calendar.
	$calendar = '<table class="calendar">'."\n".
        '<tr><th class="calendar-title" colspan="8">'.$title.'</td></tr><tr>';
        
    $calendar .= '<th class="calendar-header">KW</th>';

    #Print day names
    foreach($day_names as $d)
        $calendar .= '<th class="calendar-header">'.substr($d,0,3).'</th>';
    $calendar .= "</tr>\n<tr>";

	if($weekday > 0)
    {
        $first_day_of_week = gmmktime(0,0,0,$month,$day,$year);
        $calendar_week = date('W', $first_day_of_week);
        
        #initial 'empty' days
        $calendar .= '<th class="calendar-week">'.$calendar_week.'</th><td colspan="'.$weekday.'">&nbsp;</td>'; 
    }
	for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){
		if($weekday == 7){
			$weekday   = 0; #start a new week
            $first_day_of_week = gmmktime(0,0,0,$month,$day+1,$year);
            $calendar_week = date('W', $first_day_of_week);
			$calendar .= '</tr><tr><th class="calendar-week">'.$calendar_week.'</th>'; #<-- Kalenderwoche
		}
		if(in_array($day, $days)) {
            $calendar .= '<td class="calendar-busy">'.$day.'</td>';
		}
		else $calendar .= '<td class="calendar-free">'.$day.'</td>';
	}
	if($weekday != 7) $calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days

	return $calendar."</tr>\n</table>\n";
}
?>