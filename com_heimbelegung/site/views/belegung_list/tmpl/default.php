<?php defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'helpers.php');

?>
<script language="javascript" type="text/javascript">

function submitform(pressbutton){
var form = document.adminForm;
   if (pressbutton)
    {form.task.value=pressbutton;}
    
    if ((pressbutton=='edit')||(pressbutton=='add')||(pressbutton=='remove'))
     {
      form.controller.value="belegung_detail";
     }
    try {
        form.onsubmit();
        }
    catch(e){}
    
    form.submit();
}
</script>

<form action="index.php?option=com_heimbelegung" method="post" name="adminForm">
<div style="float:left;border: 1px solid lightgray;padding:17px">
    Heim:
    <input type="radio" name="heim" value="buschi" onchange="submitform()"
        <?php if ($this->heim == 'buschi') echo 'checked="checked"' ?>
    >B&uuml;schiheim</input>
    <input type="radio" name="heim" value="weiermatt" onchange="submitform()"
        <?php if ($this->heim == 'weiermatt') echo 'checked="checked"' ?>
    >Weiermattheim</input>
</div>

<div style="clear:both" id="editcell">
    <table class="adminform">
		<tbody>
			<tr>
                <td width="100%"><?php if ($this->filter == 1) echo "Belegungen die in der Vergangenheit liegen sind ausgeblendet"; ?></td>
				<td align="right">
                    <select name="filter" id="filter" class="inputbox" size="1" onchange="document.adminForm.submit();">
                        <option value="1" <?php if ($this->filter == 1) echo 'selected="selected"'; ?>>Aktuelle Belegungen</option>
                        <option value="0" <?php if ($this->filter == 0) echo 'selected="selected"'; ?> >Alle Belegungen</option>
                    </select>
                </td>
			</tr>
		</tbody>
	</table>
    <table class="adminlist" style="width:100%">
    <thead>
        <tr>
            <th width='10'>#</th>
            <th width="20">
                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->belegung ); ?>);" />
            </th>
            <th>Von</th>
            <th>Bis</th>
            <th>Belegung erster Tag</th>
            <th>Belegung letzter Tag</th>
            <th>Beschreibung</th>
            <th>Heim</th>
        </tr>
    </thead>
    <?php
    $i = 0;
    $k = 0;
    foreach($this->belegung as $b)
    {
        $checked = JHTML::_( 'grid.id', $i, $b->id );
    ?>
        <tr class='<?php echo 'row'.$k; ?>'>
            <td><?php echo $b->id; ?></td>
            <td><?php echo $checked; ?></td>
            <td>
                <span class='editlinktip hasTip' title='Edit::Belegung vom <?php echo date_mysql2german($b->von); ?>'>
                    <a href='index.php?option=com_heimbelegung&controller=belegung_detail&task=edit&cid[]=<?php echo $b->id; ?>'>
                        <?php echo date_mysql2german($b->von); ?>
                    </a>
                </span>
            </td>
            <td><?php echo date_mysql2german($b->bis); ?></td>
            <td><?php echo humanReadable($b->vonTageszeit); ?></td>
            <td><?php echo humanReadable($b->bisTageszeit); ?></td>
            <td><?php echo $b->beschreibung; ?></td>
            <td><?php echo heimName($b->heim); ?></td>
        </tr>
    <?php
        $i += 1;
        $k = 1 - k;
    } ?>
    </table>
</div>

<input type="hidden" name="option" value="com_heimbelegung" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="belegung_list" />
 
</form>
