<?php// Sicherheitscheckdefined('_JEXEC') or die('Restricted access');require_once(JPATH_COMPONENT.DS.'calendar'.DS.'calendar.php');function getEditButton(){    $user =& JFactory::getUser();    if ($user->authorize('com_heimbelegung', 'edit'))    {        return "<span class='hasTip' title='Tageler editieren'>                    <a href='index.php?option=com_heimbelegung&controller=belegung&task=edit'>                        <img src='images/M_images/edit.png' alt='edit' />                    </a>                </span>";    }    return '';}function date_mysql2german($date){    $d    =    explode('-',$date);    return    sprintf('%02d.%02d.%04d', $d[2], $d[1], $d[0]);}// Als besetzt zu markierende Tage errechnen$days = array();foreach ($this->belegung as $b){    $von = strtotime($b->von);    $first = strtotime($this->year.'-'.$this->month.'-01');        $bis = strtotime($b->bis);    $last = strtotime($this->year.'-'.$this->month.'-'.date('t', $first));        if ($von < $first) $von = $first;    if ($bis > $last) $bis = $last;    $day_von   = date('j', $von);    $day_bis   = date('j', $bis);    $day_count = $day_bis - $day_von;        for ($i = 0; $i <= $day_count; $i++)    {        $day = $day_von + $i;        if ($i == 0) $days[$day] = $b->vonTageszeit;        else if ($i == $day_count) $days[$day] = $b->bisTageszeit;        else $days[$day] = 'B';    }}// Angaben f�r die Links zum letzten/n�chsten Monat// -> Nicht korrekte Angaben werden automatisch korrigiert 01.13.2010 -> 01.01.2011$next_month = $this->month + 1;$next_year = $this->year;if ($next_month == 13){    $next_month = 1;    $next_year += 1;}$prev_month = $this->month - 1;$prev_year = $this->year;if ($prev_month == 0){    $prev_month = 12;    $prev_year -= 1;}?><style type="text/css">.calendar {    border: solid 1px;    text-align: center;    border-spacing: 0px;    width:100%;    margin-top: 10px;    border-collapse: collapse;}.calendar th {    font-weight: normal;    background-color: #eeeeee;}.calendar td {    width:23px;    color:white;    border: solid 1px black;}.calendar-title {    border-bottom: solid 1px;}.calendar-header {    border-bottom: solid 1px;}.calendar-week {    border-right: solid 1px;}.calendar-free {    background-color: #009900;}.calendar-busy {    background-color: #df0000;}</style><div class='componentheading'>    Heimbelegung    <?php echo getEditButton(); ?><br /></div><div class='contentpaneopen' style="width:400px">    <form action="" method="post">        Heim:        <input type="radio" name="heim" value="buschi"            <?php if ($this->heim == 'buschi') echo 'checked="checked"' ?>        >B&uuml;schiheim</input>        <input type="radio" name="heim" value="weiermatt"            <?php if ($this->heim == 'weiermatt') echo 'checked="checked"' ?>        >Weiermattheim</input>                <input type="submit" value="Aktualisieren" style="float:right" />                <a href="index.php?option=com_heimbelegung&month=<?php echo $prev_month; ?>&year=<?php echo $prev_year; ?>&heim=<?php echo $this->heim; ?>">            <button style="float:left;clear:both">&lt;--</button>        </a>        <a href="index.php?option=com_heimbelegung&month=<?php echo $next_month; ?>&year=<?php echo $next_year; ?>&heim=<?php echo $this->heim; ?>">            <button style="float:right">--&gt;</button>        </a>    </form>    <?php echo generate_calendar($this->year, $this->month, $days); ?>    Zuletzt aktualisiert am: <?php echo date_mysql2german($this->last_mod); ?></div></body></html>