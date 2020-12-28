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

jimport('joomla.application.component.controller');

$controller = JControllerLegacy::getInstance('Belegung');
$controller->execute(JRequest::getVar('task'));
$controller->redirect();
