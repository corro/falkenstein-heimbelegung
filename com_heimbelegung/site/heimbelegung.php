<?php
/**
 * Einstiegspunkt f�r das Heimbelegungs Component
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

// TODO: Editierfunktionen beschr�nken

// Controller instanzieren
$classname  = $controller.'controller';
$controller = new $classname();

// Request bearbeiten
$controller->execute(JRequest::getVar('task'));

// Redirect wenn n�tig
$controller->redirect();
