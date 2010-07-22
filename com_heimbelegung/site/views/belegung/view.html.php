<?php/** * Belegung View f�r das Heimbelegungs Component *  * @package    Falkenstein.Joomla * @subpackage Components * @link       http://www.pfadi-falkenstein.ch * @license		GNU/GPL */// Import der Basisklassejimport( 'joomla.application.component.view');/** * Viewklasse f�r die Belegungs�bersicht * * @package		Falkenstein.Joomla * @subpackage	Components */class BelegungViewBelegung extends JView{    function display($tpl = null)    {        $heim     = JRequest::getVar('heim', 'buschi');        $month    = JRequest::getInt('month', date('n'));        $year     = JRequest::getInt('year', date('Y'));                $start_data = array($year, $month, 01);        $start_date = join('-', $start_data);                $last_day = date('t', $start_date);        $stop_data = array($year, $month, $last_day);        $stop_date = join('-', $stop_data);                // Daten laden        $model = $this->getModel();        $belegung = $model->getBelegung($heim, $start_date, $stop_date);        $last_mod = $model->getLastModified();        // Inhalt f�r das Template definieren        $this->assignRef('belegung', $belegung);        $this->assignRef('heim', $heim);        $this->assignRef('month', $month);        $this->assignRef('year', $year);        $this->assignRef('last_mod', $last_mod);        // Browsertitel anpassen        $document = JFactory::getDocument();        $document->setTitle('Heimbelegung');        parent::display($tpl);    }}