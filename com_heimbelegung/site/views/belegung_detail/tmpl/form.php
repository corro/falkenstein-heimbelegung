<?php
// Sicherheitscheck
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'helpers.php');
JHTML::_('behavior.tooltip');
JHTML::_('behavior.calendar'); // Kalender-Script vorbereiten

prepareCalendar('von', 'von_img');
prepareCalendar('bis', 'bis_img');

?>

<script language="javascript" type="text/javascript">
<!--
function submitbutton(pressbutton)
{
    submitform(pressbutton);
}
//-->
</script>

<style type="text/css">
.input {
    width: 100%;
}
textarea.input {
    height: 100px;
}
</style>

<div class='componentheading'>
    Heimbelegung <small><small><?php if (isset($this->belegung)) echo '[Editieren]'; else echo '[Erfassen]'; ?></small></small>
</div>

<div style="clear:both">
    <?php echo $this->toolbar; ?>
</div>

<div class='contentpaneopen'>
    <form style="clear:both" action="index.php" method="post" name="adminForm" id="adminForm">
        <fieldset>
        <legend>Belegung</legend>
        <table class="admintable">
            <tr>
                <td class="key"
                    <label for="von">Von:</label>
                </td>
                <td>
                    <input style="vertical-align:top;width:80%" class="input" type="text" name="von" id="von" value="<?php if (isset($this->belegung)) echo date_mysql2german($this->belegung->von); ?>" />
                    <img class="calendar" src="templates/system/images/calendar.png" alt="calendar" name="von_img" id="von_img" />
                </td>
            </tr>
            <tr>
                <td class="key">
                    <label for="bis">Bis:</label>
                </td>
                <td>
                    <input style="vertical-align:top;width:80%" class="input" type="text" name="bis" id="bis" value="<?php if (isset($this->belegung)) echo date_mysql2german($this->belegung->bis); ?>" />
                    <img class="calendar" src="templates/system/images/calendar.png" alt="calendar" name="bis_img" id="bis_img" />
                </td>
            </tr>
            <tr>
                <td class="key" style="vertical-align:top">
                    <label for="von_tagesz" class="hasTip" title="Wenn die Belegung erst Nachmittags beginnt bitte hier ausw&auml;hlen">Belegung erster Tag:</label>
                </td>
                <td>
                    <select class="input" name="von_tagesz">
                        <option value="B">Vor- und Nachmittag</option>
                        <option value="N">Nachmittag</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="key">
                    <label for="bis_tagesz" class="hasTip" title="Wenn die Belegung bereits Vormittags endet bitte hier ausw&auml;hlen">Belegung letzter Tag:</label>
                </td>
                <td>
                    <select class="input" name="bis_tagesz">
                        <option value="B">Vor- und Nachmittag</option>
                        <option value="V">Vormittag</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="key">
                    <label for="heim">Heim:</label>
                </td>
                <td>
                    <select class="input" name="heim">
                        <option value="buschi" <?php if ((isset($this->belegung) and $this->belegung->heim == 'buschi') or $this->heim == 'buschi') echo 'selected="selected"'; ?>>B&uuml;schiheim</option>
                        <option value="weiermatt" <?php if ((isset($this->belegung) and $this->belegung->heim == 'weiermatt') or $this->heim == 'weiermatt') echo 'selected="selected"'; ?>>Weiermattheim</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="key" style="vertical-align:top;">
                    <label for="beschreibung" class="hasTip" title="Dieser Text dient der Identifikation der Belegung, ist aber nur als Gedankenst&uuml;tze gedacht. Sinnvollerweise k&ouml;nnte der Name des Mieters angegeben werden">Beschreibung:</label>
                </td>
                <td>
                    <textarea class="input" name="beschreibung" id="beschreibung"><?php if (isset($this->belegung)) echo $this->belegung->beschreibung; ?></textarea>
                </td>
            </tr>
        </table>

        <input type="hidden" name="id" value="<?php if (isset($this->belegung)) echo $this->belegung->id; ?>" />
        <input type="hidden" name="option" value="com_heimbelegung" />
        <input type="hidden" name="task" value="save" />
        <input type="hidden" name="controller" value="belegung_detail" />
        <?php echo JHTML::_( 'form.token' ); ?>
        </fieldset>
    </form>
</div>