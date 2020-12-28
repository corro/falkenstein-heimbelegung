<?php
/**
 * Belegung Controller für das Heimbelegung Component
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

setlocale(LC_ALL, 'de_CH.UTF-8');

/**
 * Belegung Controller
 *
 * @package    Falkenstein.Joomla
 * @subpackage Components
 */
class BelegungController extends JControllerLegacy
{
    public function edit()
    {
        $model = $this->getModel('belegung');
        $view = $this->getView('edit', 'html');
        $view->setModel($model, true);
        JRequest::setVar('view', 'edit');
        parent::display();
    }

    public function save()
    {
        $heim     = JRequest::getVar('heim', 'buschi');
        $month    = JRequest::getInt('month', date('n'));
        $year     = JRequest::getInt('year', date('Y'));
        $belegung = JRequest::getVar('belegung', array());
        $model = $this->getModel('belegung');
        $model->saveBelegung($heim, $year, $month, $belegung);
        $this->edit();
    }
}
