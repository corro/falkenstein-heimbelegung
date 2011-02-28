<?php

function getEditButton($component, $title, $controller)
{
    $user =& JFactory::getUser();
    if ($user->authorise('core.edit', $component))
    {
        $link = JRoute::_('index.php?option='.$component.'&controller='.$controller.'&task=edit');
        return '<span class="hasTip" title="'.$title.'">
                    <a href="'.$link.'">
                        <img src="images/M_images/edit.png" alt="edit" />
                    </a>
                </span>';
    }
    return '';
}

function date_mysql2german($date)
{
    $d    =    explode('-',$date);
    return    sprintf('%02d.%02d.%04d', $d[2], $d[1], $d[0]);
}

function humanReadable($tageszeit)
{
    switch ($tageszeit)
    {
        case 'V':
            return 'Vormittag';
        case 'N':
            return 'Nachmittag';
        default:
            return 'Vor- und Nachmittag';
    }
}

function heimName($heim_id)
{
    if ($heim_id == 'buschi')
        return 'B&uuml;schiheim';
    else if ($heim_id == 'weiermatt')
        return 'Weiermattheim';
    else return null;
}

function prepareCalendar($input, $button)
{
    $document =& JFactory::getDocument();
    $document->addScriptDeclaration(
        "window.addEvent('domready', function() {Calendar.setup({
            inputField     :    '$input',     // id of the input field
            ifFormat       :    '%d.%m.%Y',      // format of the input field
            button         :    '$button',  // trigger for the calendar (button ID)
            align          :    'Tl',           // alignment (defaults to 'Bl')
            singleClick    :    true
        });});"
    );
}
