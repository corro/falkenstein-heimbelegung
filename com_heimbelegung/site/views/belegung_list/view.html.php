<?php
/**
 * Belegungen-List View für das Tageler Component
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
jimport('joomla.html.toolbar');
 
/**
 * Belegungen-List View
 *
 * @package    Falkenstein.Joomla
 * @subpackage Components
 */
class Belegung_ListViewBelegung_List extends JView
{
    function display($tpl = null)
    {
        $toolbar =& new JToolBar( 'Belegung' );
        $toolbar->appendButton( 'Standard', 'delete', 'Belegung l&ouml;schen', 'remove', true);
        $toolbar->appendButton( 'Standard', 'edit', 'Belegung editieren', 'edit', true);
        $toolbar->appendButton( 'Standard', 'new', 'Belegung hinzuf&uuml;gen', 'add', false);
        echo $toolbar->render();
        
        $app =& JFactory::getApplication();
        $filter = $app->getUserStateFromRequest('belegung.filter', 'filter', 1);
        $heim   = $app->getUserStateFromRequest('belegung.heim', 'heim', 'buschi');
        
        // Browsertitel anpassen
        $document = JFactory::getDocument();
        $document->setTitle('Heimbelegungsliste');
        $document->addStyleSheet(JURI::base().'components/com_heimbelegung/css/toolbar-style.css');
        
        // Get data from the model
        $model =& $this->getModel();
        $belegung = $model->getBelegungForHeim($heim, $filter);

        $this->assignRef( 'belegung', $belegung );
        $this->assignRef( 'heim', $heim );
        $this->assignRef( 'filter', $filter );

        parent::display($tpl);
    }
}
