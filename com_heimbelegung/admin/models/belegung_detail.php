<?php
/**
 * Belegungs-Detail Model f�r das Heimbelegung Component
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
 * Belegungs-Detail Model
 *
 * @package    Falkenstein.Joomla
 * @subpackage Components
 */
class Belegung_DetailModelBelegung_Detail extends JModel
{
    /**
     * Liefert die Belegungsdaten mit der angegebenen Id
     * @return Belegungsdaten
     */
    function getBelegung($id)
    {
        $app =& JFactory::getApplication();
        $db  =& JFactory::getDBO();

        $query = 'SELECT * FROM #__belegung'.
                 ' WHERE id = '.$db->quote($id);

        $db->setQuery($query);
        $belegung = $db->loadObject();

        if (is_null($belegung))
        {
            $app->enqueueMessage(nl2br($db->getErrorMsg()),'error');
        }

        return $belegung;
    }

    /**
     * Speichert einen Belegungseintrag mit den Daten aus dem JRequest
     */
    function store($data)
    {
        $app =& JFactory::getApplication();
        $db  =& JFactory::getDBO();

        $v          = explode('.', $data['von']);
        $b          = explode('.', $data['bis']);
        
        $id         = $db->quote($data['id']);
        $von        = $db->quote(sprintf("%04d-%02d-%02d", $v[2], $v[1], $v[0]));
        $bis        = $db->quote(sprintf("%04d-%02d-%02d", $b[2], $b[1], $b[0]));
        $von_tagesz = $db->quote($data['von_tagesz']);
        $bis_tagesz = $db->quote($data['bis_tagesz']);
        $beschreibung = $db->quote($data['beschreibung']);
        $heim       = $db->quote($data['heim']);

        if ($data['id'])
        {
            $query = 'UPDATE #__belegung
                      SET von = '.$von.', bis = '.$bis.', vonTageszeit = '.$von_tagesz.', bisTageszeit = '.$bis_tagesz.', '.
                         'beschreibung = '.$beschreibung.', heim = '.$heim.' WHERE id = '.$id;
        }
        else
        {
            $query = 'INSERT INTO #__belegung (von, bis, vonTageszeit, bisTageszeit, beschreibung, heim)
                      VALUES ('.$von.', '.$bis.', '.$von_tagesz.', '.$bis_tagesz.', '.$beschreibung.', '.$heim.')';
        }

        $db->setQuery($query);
        if (!$db->query())
        {
            $app->enqueueMessage(nl2br($db->getErrorMsg()), 'error');
            return false;
        }
        
        $query = 'UPDATE #__belegung_info SET aktualisiert = NOW()';
        $db->setQuery($query);
        $db->query();

        return true;
    }
    
    /**
     * L�scht ein oder mehrere Belegungseintr�ge
     */
    function delete($cid = array())
    {
        $app =& JFactory::getApplication();
        $db  =& JFactory::getDBO();

        if (count( $cid ))
        {
            $cids = implode( ',', $cid );
            $query = 'DELETE FROM #__belegung WHERE id IN ( '.$cids.' )';
            $db->setQuery( $query );
            if(!$db->query()) {
                $app->enqueueMessage(nl2br($db->getErrorMsg()), 'error');
                return false;
            }

            return true;
        }

        return false;
    }
}
