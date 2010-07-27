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
        parent::display();
    }
}