<?php

/* ------------------------------------------------------------------------
  # com_xcideveloper - Seamless merging of CI Development Style with Joomla CMS
  # ------------------------------------------------------------------------
  # author    Xavoc International / Gowrav Vishwakarma
  # copyright Copyright (C) 2011 xavoc.com. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
  # Websites: http://www.xavoc.com
  # Technical Support:  Forum - http://xavoc.com/index.php?option=com_discussions&view=index&Itemid=157
  ------------------------------------------------------------------------- */
// no direct access
defined('_JEXEC') or die('Restricted access');
?><?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

jimport('joomla.html.toolbar');

class xMlmToolBars extends JObject {

    function getDefaultToolBar() {

        JToolBarHelper::title('XAVOC mlm software', 'generic.png');
//              JToolBarHelper::
        $u = JFactory::getUser();
        if ($u->username == 'admin')
            JToolBarHelper::addNewX("config_cont.index", "Configurations");
        JToolBarHelper::addNewX("kits_cont.dashboard", "Kits");
        JToolBarHelper::addNewX("pins_cont.dashboard", "Pins");
        JToolBarHelper::addNewX("admindistributor_cont.dashboard", "Distributors");
        JToolBarHelper::addNewX('closing_cont.index', 'Closings');
        JToolBarHelper::addNewX('survey_cont.index', 'Surveys');
//              JToolBarHelper::back();
    }

    function KitManagementToolBar() {
        JToolBarHelper::title('Manage Kits Here', 'generic.png');
        JToolBarHelper::addNewX("kits_cont.addnewform", "Add New Kit");
        JToolBarHelper::addNewX("kits_cont.formReport", "Datewise Report");
//              JToolBarHelper::save('project.saveNewProject');
        JToolBarHelper::cancel('com_mlm.index');
    }
    function formKitToolBar(){
        JToolBarHelper::title('Find Report here', 'generic.png');
        JToolBarHelper::cancel('kits_cont.dashboard');
    }
    function addKitToolBar() {
        JToolBarHelper::title('Add a new Kit here', 'generic.png');
//              JToolBarHelper::save("kits_cont.addkit","save");
//              JToolBarHelper::save('project.saveNewProject');
        JToolBarHelper::cancel('kits_cont.dashboard');
    }
    function showReportKitToolBar() {
        JToolBarHelper::title('Showing Report', 'generic.png');
//              JToolBarHelper::save("kits_cont.addkit","save");
//              JToolBarHelper::save('project.saveNewProject');
        JToolBarHelper::cancel('kits_cont.formReport');
    }

    function PinsManagementToolBar() {
        JToolBarHelper::title('Manage Pins Here', 'generic.png');
//            JToolBarHelper::addNewX("pins_cont.generatenewpins","Pin Generation");
//            JToolBarHelper::addNewX("pins_cont.searchpins","Pin Management");
//              JToolBarHelper::save('project.saveNewProject');
        JToolBarHelper::cancel('com_mlm.index');
    }

    function configToolBar() {
        JToolBarHelper::title('Manage Configurations Here', 'generic.png');
        JToolBarHelper::preferences('com_mlm', '500');
        JToolBarHelper::cancel('com_mlm.index');
    }

    function configEditToolBar($configFile) {
        JToolBarHelper::title("Edit $configFile Config Here", 'generic.png');
        JToolBarHelper::save('config_cont.saveConfig');
        JToolBarHelper::cancel('config_cont.index');
    }

    function distributorToolBar() {
        $c = new xConfig('editing_id_tree');
        JToolBarHelper::title("Distributor Management", 'generic.png');
        JToolBarHelper::addNewX("admindistributor_cont.search", "Search");
        JToolBarHelper::addNewX("admindistributor_cont.getInvoice", "Invoice");
        JToolBarHelper::addNewX("admindistributor_cont.SMS", "SMS");
        if($c->getkey("AllowTreeShift") != 0)
            JToolBarHelper::addNewX("admindistributor_cont.shiftidform", "ID SHIFT");
        JToolBarHelper::cancel('com_mlm.index');
    }

    function distributorSearchToolBar() {
        JToolBarHelper::title("Distributor Search Page", 'generic.png');
        JToolBarHelper::cancel('admindistributor_cont.dashboard');
    }

    function distributorActionPageToolBar() {
        JToolBarHelper::title("Distributor Action Page", 'generic.png');
        JToolBarHelper::cancel('com_mlm.index', 'MLM root');
        JToolBarHelper::cancel('admindistributor_cont.dashboard', 'Distributor Management');
        JToolBarHelper::cancel('admindistributor_cont.search', 'Distributor Search');
    }

    function defaultCloingToolBar() {
        $c = new xConfig('closings_config');
        global $com_params;
        JToolBarHelper::title("Closing Management", 'generic.png');
        if ($com_params->get('UseSession'))
            JToolBarHelper::addNewX("closing_cont.sessionclosing", "Session");
        if ($com_params->get('UseMidSession'))
            JToolBarHelper::addNewX("closing_cont.midsessionclosing", "MidSession");
        JToolBarHelper::addNewX("closing_cont.dateWiseRewards", "Date Wise Rewards");
        JToolBarHelper::addNewX("closing_cont.mainclosing", "Main Closing");
        JToolBarHelper::cancel('com_mlm.index', 'Back');
    }

    function mainClosingToolBar() {
        JToolBarHelper::title("Main or Payout Closing", 'generic.png');
        JToolBarHelper::cancel('closing_cont.index', 'Closings');
        JToolBarHelper::cancel('com_mlm.index', 'Mlm Root');
    }

    function surveyManagementToolBar(){
        JToolBarHelper::title("Add Surveys", 'generic.png');
        JToolBarHelper::addNewX("survey_cont.addSurveyForm", "Add New Survey");
        JToolBarHelper::cancel('com_mlm.index');
    }

    function cancleDefault($title,$url){
        JToolBarHelper::title($title, 'generic.png');
        JToolBarHelper::cancel($url);
    }

}

?>
