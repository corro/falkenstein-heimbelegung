<?php
/**
 * Belegungs-Listen Controller für das Heimbelegung Component
 * 
 * @package    Falkenstein.Joomla
 * @subpackage Components
 * @link       http://www.pfadi-falkenstein.ch
 * @license		GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import der Basisklasse
jimport('joomla.application.component.controller');

/**
 * Belegungs-Listen Controller
 *
 * @package    Falkenstein.Joomla
 * @subpackage Components
 */
class Belegung_ListController extends JController
{
    /**
     * Custom Constructor
     */
    function __construct( $default = array())
    {
        parent::__construct( $default );

        $this->addModelPath( JPATH_COMPONENT_ADMINISTRATOR .DS.'models' );
    }

    /**
     * Standardansicht
     */
    function display()
    {
        $user =& JFactory::getUser();
        if (!$user->authorise('core.edit', $component))
        {
            echo '<h1>Zugriff verweigert</h1>Dieser Bereich ist den Leitern und Administratoren vorbehalten';
            return;
        }

        JRequest::setVar('view', 'belegung_list');
        
        parent::display();
    }
    
    function back()
    {
        $this->setRedirect('index.php?option=com_heimbelegung');
    }
}
