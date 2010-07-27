<?php
/**
 * Belegungs-Detail View für das Heimbelegung Component
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
jimport('joomla.html.toolbar');
 
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

        $toolbar =& new JToolBar( 'Belegung' );
        $toolbar->appendButton( 'Standard', 'save', 'Belegung speichern', 'save', false);
        
        if ($id)
        {
            $toolbar->appendButton( 'Standard', 'cancel', 'Schliessen', 'cancel', false);

            // Get data from the model
            $model   = $this->getModel();
            $belegung = $model->getBelegung($id);

            $this->assignRef( 'belegung', $belegung );
        }
        else
        {
            $toolbar->appendButton( 'Standard', 'cancel', 'Abbrechen', 'cancel', false);
        }
        
        echo $toolbar->render();
        
        // Browsertitel anpassen
        $document = JFactory::getDocument();
        $document->setTitle('Belegung bearbeiten');
        $document->addStyleSheet(JURI::base().'components/com_heimbelegung/css/toolbar-style.css');
        
        $this->assignRef('heim', $heim);

        parent::display($tpl);
    }
}
