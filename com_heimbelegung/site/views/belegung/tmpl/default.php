<?php
// Sicherheitscheck
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
require_once(JPATH_COMPONENT.DS.'calendar'.DS.'calendar.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'helpers.php');

?>

<script language="javascript" type="text/javascript">
<!--

function submitform()
{
    document.calendar.submit();
}

function changeMonth(month, year)
{
    document.getElementById('month').value = month;
    document.getElementById('year').value = year;
    submitform();
}

//-->
</script>


<div class='componentheading'>
    Heimbelegung <?php echo heimName($this->heim); ?> im
    <?php echo gmstrftime('%B', gmmktime(0,0,0,$this->month,1,$this->year)); ?> <?php echo $this->year; ?>
    <?php echo getEditButton('com_heimbelegung', 'Belegungen editieren', 'belegung_list'); ?><br />
</div>

<div class='contentpaneopen'>
    <form name="calendar" action="" method="post">
        <img style="float:left;cursor:pointer" width="22" height="22" class="hasTip" src="components/com_heimbelegung/img/go-previous.png"
             title="Einen Monat zur&uuml;ck" alt="previous"
             onclick="changeMonth(<?php echo gmdate('n', $this->prev); ?>, <?php echo gmdate('Y', $this->prev); ?>)" />
        <div style="float:left">
            Heim:
            <input type="radio" name="heim" value="buschi" onchange="submitform()"
                <?php if ($this->heim == 'buschi') echo 'checked="checked"' ?>
            >B&uuml;schiheim</input>
            <input type="radio" name="heim" value="weiermatt" onchange="submitform()"
                <?php if ($this->heim == 'weiermatt') echo 'checked="checked"' ?>
            >Weiermattheim</input>
        </div>
        
        <img style="float:right;cursor:pointer" width="22" height="22" class="hasTip"
             src="components/com_heimbelegung/img/go-next.png" title="Einen Monat vorw&auml;rts" alt="next"
             onclick="changeMonth(<?php echo gmdate('n', $this->next); ?>, <?php echo gmdate('Y', $this->next); ?>)" />
             
        <img style="float:right;cursor:pointer" width="22" height="22" class="hasTip"
             src="components/com_heimbelegung/img/view-refresh.png" onclick="submitform()" title="Refresh" alt="refresh" />
        
        <div style="float:right">
            <select name="goto_month" id="goto_month" onchange="changeMonth(document.getElementById('goto_month').value, <?php echo $this->year; ?>)">
                <?php
                    for ($i = 1; $i <= 12; $i++)
                    {
                        echo '<option value="'.$i.'"';
                        if ($i == $this->month) echo ' selected="selected"';
                        echo '>'.gmstrftime('%B', gmmktime(0,0,0,$i,1,$this->year)).'</option>';
                    }
                ?>
            </select>
            <select name="goto_year" id="goto_year" onchange="changeMonth(<?php echo $this->month; ?>, document.getElementById('goto_year').value)">
                <?php
                    for ($i = -5; $i <= 5; $i++)
                    {
                        echo '<option';
                        if ($i == 0) echo ' selected="selected"';
                        echo '>'.($this->year + $i).'</option>';
                    }
                ?>
            </select>
        </div>
        
        <input type="hidden" name="month" id="month" value="<?php echo $this->month; ?>" />
        <input type="hidden" name="year" id="year" value="<?php echo $this->year; ?>" />
    </form>
    <div style="clear:both"></div>
    <hr />
    <div style="width:400px;margin-left:auto;margin-right:auto">
        <?php echo generate_calendar($this->year, $this->month, $this->days); ?>
        V = Vormittag, N = Nachmittag<br />
        <span style="font-size:8pt;color:gray">Zuletzt aktualisiert am: <?php echo date_mysql2german($this->last_mod); ?></span>
    </div>
</div>