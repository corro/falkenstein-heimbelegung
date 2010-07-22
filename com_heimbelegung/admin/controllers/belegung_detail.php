<?php
/**
 * Belegungs-Detail Controller für das Heimbelegungs Component
 * 
 * @package    Falkenstein.Joomla
 * @subpackage Components
 * @link       http://www.pfadi-falkenstein.ch
 * @license    GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import der Basisklasse
jimport( 'joomla.application.component.controller' );


/**
 * Belegungs-Detail Controller
 *
 * @package     Falkenstein.Joomla
 * @subpackage  Components
 */
class Belegung_DetailController extends JController
{
    /**
     * Custom Constructor
     */
    function __construct( $default = array())
    {
        parent::__construct( $default );

        // Register Extra tasks
        $this->registerTask( 'add', 'edit' );
    }

    /**
     * display the edit form
     * @return void
     */
    function edit()
    {
        JRequest::setVar( 'view', 'belegung_detail' );
        JRequest::setVar( 'layout', 'form'  );
        JRequest::setVar( 'hidemainmenu', 1 );

        parent::display();
    }

    /**
     * Speicheraufruf
     */
    function save()
    {
        // Sicherheitsüberprüfung zum Verhindern von Request-Fälschungen
        JRequest::checkToken() or jexit('Invalid Token');

        $model =& $this->getModel();
        $post = JRequest::get('post');

        // Speichern der Informationen
        if ($model->store($post)) {
            $msg = 'Belegung erfolgreich gespeichert';
        } else {
            $msg = 'Fehler beim Speichern der Belegung';
        }

        $this->setRedirect('index.php?option=com_heimbelegung', $msg);
    }

    function remove()
    {
        $heim = JRequest::getVar( 'heim' );
        $cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );

        $model = $this->getModel();
        if ($model->delete($cid)) {
            $msg = 'Belegung erfolgreich entfernt';
        } else {
            $msg = 'Fehler beim Entfernen der Belegung';
        }

        $redirect = 'index.php?option=com_heimbelegung';
        if ($heim)
            $redirect .= '&heim='.$heim;
        $this->setRedirect( $redirect, $msg);
    }

    /**
    * Abbruch
    */
    function cancel()
    {
        $this->setRedirect( 'index.php?option=com_heimbelegung', $msg);
    }
}
