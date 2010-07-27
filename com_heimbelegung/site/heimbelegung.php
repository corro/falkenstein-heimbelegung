<?php
/**
 * Einstiegspunkt für das Heimbelegungs Component
 * 
 * @package    Falkenstein.Joomla
 * @subpackage Components
 * @link       http://www.pfadi-falkenstein.ch
 * @license    GNU/GPL
 */

// Sicherheitscheck
defined('_JEXEC') or die('Restricted access');

$controller = JRequest::getVar('controller','belegung');

require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');

// Editierfunktionen beschränken
$auth =& JFactory::getACL();
$auth->addACL('com_heimbelegung', 'edit', 'users', 'super administrator');
$auth->addACL('com_heimbelegung', 'edit', 'users', 'administrator');
$auth->addACL('com_heimbelegung', 'edit', 'users', 'author');

// Controller instanzieren
$classname  = $controller.'controller';
$controller = new $classname();

// Request bearbeiten
$controller->execute(JRequest::getVar('task'));

// Redirect wenn nötig
$controller->redirect();
