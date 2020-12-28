<?php
/**
 * Belegung Model für das Heimbelegung Component
 * 
 * @author     R. Baumgartner
 * @package    Falkenstein.Joomla
 * @subpackage Components
 * @link       http://www.pfadi-falkenstein.ch
 * @license    GNU/GPL
 */

// Sicherheitscheck
defined('_JEXEC') or die('Restricted access');

// Import der Basisklasse
jimport( 'joomla.application.component.model' );

/**
 * Belegung Model
 *
 * @package    Falkenstein.Joomla
 * @subpackage Components
 */
class BelegungModelBelegung extends JModelLegacy
{
    function getBelegungForHeim($heim, $filter = 1)
    {
        $app =& JFactory::getApplication();
        $db =& JFactory::getDBO();
        
        $heim = $db->quote($heim);
        
        $query = 'SELECT * FROM #__belegung WHERE heim = '.$heim;
        if ($filter)
            $query .= ' AND datum > NOW()';
        $query .= ' ORDER BY von';
        
        $db->setQuery($query);
        $belegung = $db->loadObjectList();
        
        if (is_null($belegung))
        {
            $app->enqueueMessage(nl2br($db->getErrorMsg()),'error');
        }

        return $belegung;
    }

    /**
     * Liefert alle Belegungen für ein Heim und einen Monat
     * @return Alle Belegungen
     */
    function getBelegung($heim, $start, $stop)
    {
        $app =& JFactory::getApplication();
        $db =& JFactory::getDBO();
        
        $heim = $db->quote($heim);
        $start = $db->quote($start);
        $stop = $db->quote($stop);
        
        $query = 'SELECT * FROM #__belegung 
                  WHERE heim = '.$heim.'
                  AND (datum BETWEEN '.$start.' AND '.$stop.')';
        $db->setQuery( $query );
        $belegung = $db->loadObjectList();

        if (is_null($belegung))
        {
            $app->enqueueMessage(nl2br($db->getErrorMsg()),'error');
        }

        return $belegung;
    }

    function saveBelegung($heim, $year, $month, $belegung)
    {
        $app =& JFactory::getApplication();
        $db =& JFactory::getDBO();
        
        $heim = $db->quote($heim);
        
        $query = 'DELETE FROM #__belegung
                  WHERE heim = '.$heim.'
                  AND MONTH(datum) = '.$month.'
                  AND YEAR(datum) = '.$year;
        $db->setQuery($query);
        $db->query();

        foreach($belegung as $b)
        {
            $s = explode('-', $b);
            $day = $s[0];
            $tageszeit = $db->quote($s[1]);
            $datum = mktime(0, 0, 0, $month, $day, $year);
            $query = 'INSERT INTO #__belegung (heim, datum, tageszeit)
                      VALUES ('.$heim.',
                        FROM_UNIXTIME('.$datum.'),
                        '.$tageszeit.')';
            $db->setQuery($query);
            $db->query();
        }

        $query = 'UPDATE #__belegung_info
                  SET aktualisiert = FROM_UNIXTIME('.time().')';
        $db->setQuery($query);
        $db->query();
    }
    
    function getLastModified()
    {
        $app =& JFactory::getApplication();
        $db  =& JFactory::getDBO();
        
        $query = 'SELECT aktualisiert FROM #__belegung_info';
        $db->setQuery( $query );
        
        $last_mod = $db->loadResult();
        
        return $last_mod;
    }
}
