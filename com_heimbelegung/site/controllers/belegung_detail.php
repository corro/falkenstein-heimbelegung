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
        $this->addModelPath( JPATH_COMPONENT_ADMINISTRATOR.DS.'models' );
    }

    /**
     * display the edit form
     * @return void
     */
    function edit()
    {
        $user =& JFactory::getUser();
        if (!$user->authorize('com_tageler', 'edit'))
        {
            echo '<h1>Zugriff verweigert</h1>Dieser Bereich ist den Leitern und Administratoren vorbehalten';
            return;
        }
        
        JRequest::setVar( 'view', 'belegung_detail' );
        JRequest::setVar( 'layout', 'form'  );

        parent::display();
    }

    /**
     * Speicheraufruf
     */
    function save()
    {
        $user =& JFactory::getUser();
        if (!$user->authorize('com_tageler', 'edit'))
        {
            echo '<h1>Zugriff verweigert</h1>Dieser Bereich ist den Leitern und Administratoren vorbehalten';
            return;
        }
        
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

        $this->setRedirect('index.php?option=com_heimbelegung&controller=belegung_list&task=edit', $msg);
    }

    function remove()
    {
        $user =& JFactory::getUser();
        if (!$user->authorize('com_tageler', 'edit'))
        {
            echo '<h1>Zugriff verweigert</h1>Dieser Bereich ist den Leitern und Administratoren vorbehalten';
            return;
        }
        
        $heim = JRequest::getVar( 'heim' );
        $cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );

        $model = $this->getModel();
        if ($model->delete($cid)) {
            $msg = 'Belegung erfolgreich entfernt';
        } else {
            $msg = 'Fehler beim Entfernen der Belegung';
        }

        $this->setRedirect( 'index.php?option=com_heimbelegung&controller=belegung_list&task=edit', $msg);
    }

    /**
    * Abbruch
    */
    function cancel()
    {
        $this->setRedirect( 'index.php?option=com_heimbelegung&controller=belegung_list&task=edit', $msg);
    }
}
