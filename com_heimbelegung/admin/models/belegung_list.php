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
class BelegungModelBelegung_List extends JModel
{
    function getBelegungForHeim($heim, $filter = 1)
    {
        $app =& JFactory::getApplication();
        $db =& JFactory::getDBO();
        
        $query = 'SELECT * FROM #__belegung';
        if ($heim != NULL and $filter == 1)
        {
            $heim = $db->quote($heim);
            $query .= ' WHERE heim = '.$heim.' AND bis > NOW()';
        }
        else if ($heim == NULL and $filter == 1)
        {
            $query .= ' WHERE bis > NOW()';
        }
        $query .= ' ORDER BY von';
        
        $db->setQuery($query);
        $belegung = $db->loadObjectList();
        
        if (is_null($belegung))
        {
            $app->enqueueMessage(nl2br($db->getErrorMsg()),'error');
        }

        return $belegung;
    }
}
