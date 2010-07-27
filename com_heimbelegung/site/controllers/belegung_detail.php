<?php
/**
 * Belegungs-Detail Controller f�r das Heimbelegungs Component
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
        JRequest::setVar( 'view', 'belegung_detail' );
        JRequest::setVar( 'layout', 'form'  );

        parent::display();
    }

    /**
     * Speicheraufruf
     */
    function save()
    {
        // Sicherheits�berpr�fung zum Verhindern von Request-F�lschungen
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
