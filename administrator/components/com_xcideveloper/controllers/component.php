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

/**
 * Description of product
 *
 * @author Xavoc
 */
class component extends CI_Controller {
    function  __construct() {
        parent::__construct();
    }

    function addNew(){
        xDeveloperToolBars::newProjectToolBar("Component");
        $this->load->view('newcomponent.html');
    }

    function saveNewComponent(){
        jimport('joomla.filesystem.file');
        $this->load->model('com_creator');
        $safefoldername = JFile::makeSafe($this->input->get("componentName"));
        if($safefoldername == ""){
            xRedirect("index.php?option=com_xcideveloper","Component Name is not accepted. Please user variable name rules","error");
        }
        $prjDetails=array(
                'version' => $this->input->get('version'),
                'name'=>$this->input->get('ComponentTitle'),
                'author'=>$this->input->get('author'),
                'creationDate'=>$this->input->get('creationDate'),
                'copyright'=>$this->input->get('copyright'),
                'license'=>$this->input->get('license'),
                'authorEmail'=>$this->input->get('authorEmail'),
                'authorUrl'=>$this->input->get('authorUrl'),
                'version'=>$this->input->get('version'),
                'description'=>$this->input->get('description')
                );
        
        $prjConfig=array(
                'includeCISystem'=>$this->input->get("includeCISystem")
        );

        if(!$this->com_creator->createNewComponent($safefoldername,$prjDetails,$prjConfig))
                xRedirect("index.php?option=com_xcideveloper","Component Already Exists.. Either Uninstall it or remove directory","error");


        xRedirect("index.php?option=com_xcideveloper","Component Created and Registered, Start developing or managing the component");
    }

    function developProject(){
        if(!is_dir(JPATH_ADMINISTRATOR.DS."components".DS."com_extplorer"))
            xRedirect ("index.php?option=com_xcideveloper&task=welcome.index", "Please install the modified extplorer from http://www.xavoc.com first", "error");

        $this->load->model('com_creator');
        $prj=$this->com_creator->getDetails(JRequest::getCmd('xprjid'));
        $this->load->library('session');
        $admin=($this->input->get('xcidevelop_side')=="")? "" : $this->input->get('xcidevelop_side')."\\";
        
        $this->session->set_userdata("xCI_home_dir",JPATH_SITE."\\${admin}components\com_".$prj->component);
        
        xRedirect("index.php?option=com_extplorer");
    }

    function generatePackage(){
        $this->load->model('com_creator');
        $this->load->helper('xcideveloper');
        $this->load->library('xXML_Writer');
        
        $prj=$this->com_creator->getDetails(JRequest::getCmd('xprjid'));

        $mainframe = JFactory::getApplication();
        $tmpDir=$mainframe->getCfg('tmp_path');
        $tmpComp=$tmpDir.DS."com_".$prj->component;

        jimport('joomla.filesystem.file');
        if(is_dir($tmpComp)){
            JFolder::delete($tmpComp);
        }
        JFolder::create($tmpComp);
        JFolder::copy(JPATH_ADMINISTRATOR.DS."components".DS."com_".$prj->component,$tmpComp.DS."admin");
        JFolder::copy(JPATH_SITE.DS."components".DS."com_".$prj->component,$tmpComp.DS."site");
        JFile::write($tmpComp.DS."manifest.xml",$prj->manifest);

        jimport( 'joomla.filesystem.archive' );

        $this->load->library("zip");
        $this->load->helper('download');

        $path = $tmpComp.DS;
        $folder_in_zip = "";

        $this->zip->add_dir($folder_in_zip);  // Create folder in zip
        $this->zip->get_files_from_folder($path, $folder_in_zip);

        $this->zip->download('com_'.$prj->component.'.zip');

        JFile::write($tmpDir.DS.'com_'.$prj->component.'.zip',$zip_file);

        xRedirect("index.php?option=com_xcideveloper", "Enjoy next project");
    }


    function removeProject(){
        $this->db->where("id",$this->input->get("xprjid"));
        $this->db->delete("xcideveloper_projects");
        xRedirect("index.php?option=com_xcideveloper","XCI project removed but NOT UNISTALLED, uninstall it manually from joomla system");
    }

}
?>