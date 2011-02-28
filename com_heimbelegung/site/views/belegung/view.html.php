<?php
/**
 * Belegung View für das Heimbelegungs Component
 * 
 * @package    Falkenstein.Joomla
 * @subpackage Components
 * @link       http://www.pfadi-falkenstein.ch
 * @license		GNU/GPL
 */

// Import der Basisklasse
jimport( 'joomla.application.component.view');

/**
 * Viewklasse für die Belegungsübersicht
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
            
            // Zeigt an, ob die Datumsgrenzen beschnitten wurden
            $cut_von = false;
            $cut_bis = false;
            
            if ($von < $start_date)
            {
                $cut_von = true;
                $von = $start_date;
            }
            if ($bis > $stop_date)
            {
                $cut_bis = true;
                $bis = $stop_date;
            }

            $day_von   = date('j', $von);
            $day_bis   = date('j', $bis);
            $day_count = $day_bis - $day_von;
            
            for ($i = 0; $i <= $day_count; $i++)
            {
                $day = $day_von + $i;

                // Behandlung der möglichen Fälle
                if ($i == 0 and !$cut_von)
                    $days[$day] = $b->vonTageszeit;
                else if ($i == 0 and $cut_von)
                    $days[$day] = 'B';
                else if ($i == $day_count and !$cut_bis)
                    $days[$day] = $b->bisTageszeit;
                else if ($i == $day_count and $cut_bis)
                    $days[$day] = 'B';
                else
                    $days[$day] = 'B';
            }
        }

        // Angaben für die Links zum letzten/nächsten Monat
        // -> Nicht korrekte Angaben werden automatisch korrigiert 01.13.2010 -> 01.01.2011
        $next = gmmktime(0,0,0,$month + 1,1,$year);
        $prev = gmmktime(0,0,0,$month - 1,1,$year);

        // Inhalt für das Template definieren
        $this->assignRef('month', $month);
        $this->assignRef('year', $year);
        $this->assignRef('days', $days);
        $this->assignRef('next', $next);
        $this->assignRef('prev', $prev);
        $this->assignRef('heim', $heim);
        $this->assignRef('last_mod', $last_mod);

        // Stylesheet hinzufügen
        $this->document->addStyleSheet('components/com_heimbelegung/css/calendar-style.css');

        // Titel setzen
        $app = JFactory::getApplication();
        $title = 'Heimbelegung';
        if ($app->getCfg('sitename_pagetitles', 0))
        {
            $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
        }
        $this->document->setTitle($title);
        
        // Warnmeldung für in der Vergangenheit liegende Monate anzeigen
        if (gmmktime(23,59,59,$month,$last_day,$year) < time())
        {
            $app =& JFactory::getApplication();
            $app->enqueueMessage('Der betrachtete Monat liegt in der Vergangenheit', 'warning');
        }

        parent::display($tpl);
    }
}
