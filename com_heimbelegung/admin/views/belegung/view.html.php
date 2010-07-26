<?php
/**
 * Belegungen View für das Tageler Component
 * 
 * @author     R. Baumgartner
 * @package    Falkenstein.Joomla
 * @subpackage Components
 * @link       http://www.pfadi-falkenstein.ch
 * @license    GNU/GPL
 */
 
// Sicherheitscheck
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'helpers.php');
jimport( 'joomla.application.component.view' );
 
/**
 * Belegungen View
 *
 * @package    Falkenstein.Joomla
 * @subpackage Components
 */
class BelegungViewBelegung extends JView
{
    function display($tpl = null)
    {
        $heim = JRequest::getVar('heim');
        $title = 'Belegungs Manager';
        $heim_name = heimName($heim);
        
        if ($heim_name) $title .= ' ('.$heim_name.')';

        JToolBarHelper::title($title, 'generic.png' );
        JToolBarHelper::deleteList();
        JToolBarHelper::editListX();
        JToolBarHelper::addNewX();
        
        $app =& JFactory::getApplication();
        $filter = $app->getUserStateFromRequest('belegung.filter', 'filter', 1);
        
        // Get data from the model
        $model =& $this->getModel();
        $belegung = $model->getBelegungForHeim($heim, $filter);

        $this->assignRef( 'belegung', $belegung );
        $this->assignRef( 'heim', $heim );
        $this->assignRef( 'filter', $filter );

        parent::display($tpl);
    }
}
