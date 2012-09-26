 <?php
/*------------------------------------------------------------------------
# com_xcideveloper - Seamless merging of CI Development Style with Joomla CMS
# ------------------------------------------------------------------------
# author    Xavoc International / Gowrav Vishwakarma
# copyright Copyright (C) 2011 xavoc.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.xavoc.com
# Technical Support:  Forum - http://xavoc.com/index.php?option=com_discussions&view=index&Itemid=157
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>


<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class mod_creator extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getAll() {
        $this->db->where('extension_type', 'mod');
        $result = $this->db->get('xcideveloper_projects');
        return $result;
    }

    function getDetails($prjID) {
        $this->db->where('id', $prjID);
        return $this->db->get('xcideveloper_projects')->row();
    }

    function createNewModule($safefoldername, $prjDetails, $prjConfig) {
        jimport('joomla.filesystem.file');
        //CHECK and copy FOLDERS (FOLDER MANAGEMENT)
        if (is_dir(JPATH_SITE . "\\modules\\mod_" . $safefoldername)) {
            return false;
        }
//        JFolder::copy(JPATH_ADMINISTRATOR. "\\components\\com_xcideveloper\\com_structure\\admin", JPATH_ADMINISTRATOR ."\\components\\com_".$safefoldername);
        JFolder::copy(JPATH_ADMINISTRATOR . "\\components\\com_xcideveloper\\mod_structure", JPATH_SITE . "\\modules\\mod_" . $safefoldername);

//        if($prjConfig['includeCISystem']=="1"){
//            JFolder::copy(JPATH_ADMINISTRATOR. "\\components\\com_xcideveloper\\com_structure\\system", JPATH_ADMINISTRATOR ."\\components\\com_".$safefoldername."\\system");
//        }
        return $this->_initComponent($safefoldername, $prjDetails, $prjConfig);
    }

    private function _initComponent($comp, $prjDetails, $prjConfig) {
        //COpy FILES (FILES MANAGEMENT)
//        JFile::copy(JPATH_ADMINISTRATOR. "\\components\\com_$comp\\xcideveloper.php", JPATH_ADMINISTRATOR ."\\components\\com_".$comp."\\$comp.php");
//        JFile::copy(JPATH_SITE. "\\modules\\mod_$comp\\xmodule.php", JPATH_SITE ."\\modules\\mod_".$comp."\\mod_$comp.php");
        $entryFile = JFile::read(JPATH_COMPONENT_ADMINISTRATOR . DS . "mod_structure" . DS . "xmodule.php");
        $entryFile = str_replace("{component}", $comp, $entryFile);
        JFile::write(JPATH_SITE . "\\modules\\mod_" . $comp . "\\mod_$comp.php", $entryFile);

//        JFile::delete(JPATH_ADMINISTRATOR. "\\components\\com_$comp\\xcideveloper.php");
        JFile::delete(JPATH_SITE . "\\modules\\mod_$comp\\xmodule.php");
        JFile::delete(JPATH_SITE . "\\modules\\mod_$comp\\xmodule.base");

        //Set new components admin /site side route for default cntroller, changee welcome.php to default controller and its class in default controller
        $this->replace_component(JPATH_SITE. "\\modules\\mod_$comp\\config\\routes.php","{component}","mod_".$comp);
        $this->replace_component(JPATH_SITE. "\\modules\\mod_$comp\\controllers\\welcome.php","{component}","mod_".$comp, JPATH_SITE. "\\modules\\mod_$comp\\controllers\\mod_$comp.php");
        JFile::delete(JPATH_SITE. "\\modules\\mod_$comp\\controllers\\welcome.php");
//        JFile::move(JPATH_SITE. "\\modules\\mod_$comp\\controllers\\welcome.php",JPATH_SITE. "\\components\\com_$comp\\controllers\\mod_$comp.php");

        // Enter in Joomlas conponents Table as well as in our xcideveloper_project table
//        $data=array(
//            'name'=>$prjDetails['name'],
//            'link'=>'option=com_'.$comp,
//            'admin_menu_link'=>'option=com_'.$comp,
//            'admin_menu_alt'=>$prjDetails['name'],
//            'option'=>'com_'.$comp,
//            'admin_menu_img'=>'js/ThemeOffice/component.png',
//            'enabled'=>1
//        );
//
//        $this->db->insert('components',$data);

        $xml = JFile::read(JPATH_COMPONENT_ADMINISTRATOR . DS . "mod_structure" . DS . "xmodule.base");

        $xml = str_replace("{name}", $prjDetails['name'], $xml);
        $xml = str_replace("{author}", $prjDetails['author'], $xml);
        $xml = str_replace("{creationDate}", $prjDetails['creationDate'], $xml);
        $xml = str_replace("{copyright}", $prjDetails['copyright'], $xml);
        $xml = str_replace("{license}", $prjDetails['license'], $xml);
        $xml = str_replace("{authorEmail}", $prjDetails['authorEmail'], $xml);
        $xml = str_replace("{authorUrl}", $prjDetails['authorUrl'], $xml);
        $xml = str_replace("{version}", $prjDetails['version'], $xml);
        $xml = str_replace("{description}", $prjDetails['description'], $xml);
        $xml = str_replace("{component}", $comp, $xml);
//        if($prjConfig['includeCISystem']=='1'){
//            $xml=  str_replace("{systemfolder}", "<folder>system</folder>", $xml);
//        }else{
//            $xml=  str_replace("{systemfolder}", "", $xml);
//        }

        $data = array(
            'com_name' => $prjDetails['name'],
            'component' => $comp,
            'extension_type' => 'mod',
            'published' => 1,
            'manifest' => $xml
        );
        $this->db->insert('xcideveloper_projects', $data);
        JFile::write(JPATH_SITE . "\\modules\\mod_$comp\\mod_$comp.xml", $xml);


        return true;
    }

    function replace_component($path, $replacewhat, $replacewith,$newpath="") {
        if($newpath=="") $newpath=$path;
        $file = JFile::read($path);
        $file = str_replace($replacewhat, $replacewith, $file);
        JFile::write($newpath, $file);
    }

}

?>