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
        JToolBarHelper::title( JText::_( 'Belegungs Manager' ), 'generic.png' );
        JToolBarHelper::deleteList();
        JToolBarHelper::editListX();
        JToolBarHelper::addNewX();

        $heim = JRequest::getVar('heim');
        // Get data from the model
        $model =& $this->getModel();
        $belegung = $model->getBelegungForHeim($heim);

        $this->assignRef( 'belegung', $belegung );
        $this->assignRef( 'heim', $heim );

        parent::display($tpl);
    }
}
