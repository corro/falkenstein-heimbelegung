<?php
/**
 * Belegung View f�r das Heimbelegungs Component
 * 
 * @package    Falkenstein.Joomla
 * @subpackage Components
 * @link       http://www.pfadi-falkenstein.ch
 * @license		GNU/GPL
 */

// Import der Basisklasse
jimport( 'joomla.application.component.view');

/**
 * Viewklasse f�r die Belegungs�bersicht
 *
 * @package		Falkenstein.Joomla
 * @subpackage	Components
 */
class BelegungViewBelegung extends JView
{
    function display($tpl = null)
    {
        $heim     = JRequest::getVar('heim', 'buschi');
        $month    = JRequest::getInt('month', date('n'));
        $year     = JRequest::getInt('year', date('Y'));
        
        $start_date = gmmktime(0,0,0,$month,1,$year);
        $last_day = date('t', $start_date);
        $stop_date = gmmktime(0,0,0,$month,$last_day,$year);
        
        // Daten laden
        $model = $this->getModel();
        $belegung = $model->getBelegung($heim, date('Y-m-d', $start_date), date('Y-m-d', $stop_date));
        $last_mod = $model->getLastModified();
        
        // Als besetzt zu markierende Tage errechnen
        $days = array();
        foreach ($belegung as $b)
        {
            $von = strtotime($b->von);
            $bis = strtotime($b->bis);
            
            if ($von < $start_date) $von = $start_date;
            if ($bis > $stop_date) $bis = $stop_date;

            $day_von   = date('j', $von);
            $day_bis   = date('j', $bis);
            $day_count = $day_bis - $day_von;
            
            for ($i = 0; $i <= $day_count; $i++)
            {
                $day = $day_von + $i;

                if ($i == 0) $days[$day] = $b->vonTageszeit;
                else if ($i == $day_count) $days[$day] = $b->bisTageszeit;
                else $days[$day] = 'B';
            }
        }

        // Angaben f�r die Links zum letzten/n�chsten Monat
        // -> Nicht korrekte Angaben werden automatisch korrigiert 01.13.2010 -> 01.01.2011
        $next = gmmktime(0,0,0,$month + 1,1,$year);
        $prev = gmmktime(0,0,0,$month - 1,1,$year);

        // Inhalt f�r das Template definieren
        $this->assignRef('month', $month);
        $this->assignRef('year', $year);
        $this->assignRef('days', $days);
        $this->assignRef('next', $next);
        $this->assignRef('prev', $prev);
        $this->assignRef('heim', $heim);
        $this->assignRef('last_mod', $last_mod);

        // Browsertitel anpassen
        $document = JFactory::getDocument();
        $document->setTitle('Heimbelegung');
        $document->addStyleSheet(JPATH_COMPONENT.DS.'css'.DS.'calendar-style.css');
        
        // Warnmeldung f�r in der Vergangenheit liegende Monate anzeigen
        if (gmmktime(0,0,0,$month,$last_day,$year) < time())
        {
            $app =& JFactory::getApplication();
            $app->enqueueMessage('Der betrachtete Monat liegt in der Vergangenheit', 'warning');
        }

        parent::display($tpl);
    }
}
