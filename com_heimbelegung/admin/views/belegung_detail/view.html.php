<?php
/**
 * Belegungs-Detail View f�r das Heimbelegung Component
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
 * Belegungs-Detail View
 *
 * @package    Falkenstein.Joomla
 * @subpackage Components
 */
class Belegung_DetailViewBelegung_Detail extends JView
{
    function display($tpl = null)
    {
        $heim = JRequest::getVar('heim', 'buschi');
        $array = JRequest::getVar('cid',  0, '', 'array');
        $id = (int)$array[0];

        JToolBarHelper::save();
        if ($id)
        {
            JToolBarHelper::title( 'Belegung: <small><small>[ Editieren ]</small></small>' );
            JToolBarHelper::cancel( 'cancel', 'Close' );

            // Get data from the model
            $model   = $this->getModel();
            $belegung = $model->getBelegung($id);

            $this->assignRef( 'belegung', $belegung );
        }
        else
        {
            JToolBarHelper::title( 'Belegung: <small><small>[ Erfassen ]</small></small>' );
            JToolBarHelper::cancel();
        }
        
        $this->assignRef('heim', $heim);

        parent::display($tpl);
    }
}
