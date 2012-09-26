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
class module extends CI_Controller {
    function  __construct() {
        parent::__construct();
    }

    function addNew(){
        xDeveloperToolBars::newProjectToolBar("Component");
        $this->load->view('newmodule.html');
    }


    function developProject(){
        if(!is_dir(JPATH_ADMINISTRATOR.DS."components".DS."com_extplorer"))
            xRedirect ("index.php?option=com_xcideveloper&task=welcome.index", "Please install the modified extplorer from http://www.xavoc.com first", "error");

        $this->load->model('mod_creator');
        $prj=$this->mod_creator->getDetails(JRequest::getCmd('xprjid'));
//        xDeveloperToolBars::developProjectToolBar($prj->com_name);
        $this->load->library('session');
//        $admin=($this->input->get('xcidevelop_side')=="")? "" : $this->input->get('xcidevelop_side')."\\";

        $this->session->set_userdata("xCI_home_dir",JPATH_SITE."\\modules\mod_".$prj->component);

        xRedirect("index.php?option=com_extplorer");
//        $this->load->view('develop_project.html');
    }

    function generatePackage(){
        $this->load->model('mod_creator','prj_mod');
        $this->load->helper('xcideveloper');
        $this->load->library('xXML_Writer');

        $prj=$this->prj_mod->getDetails(JRequest::getCmd('xprjid'));

        $mainframe = JFactory::getApplication();
        $tmpDir=$mainframe->getCfg('tmp_path');
        $tmpMod=$tmpDir.DS."mod_".$prj->component;

        jimport('joomla.filesystem.file');
        if(is_dir($tmpMod)){
            JFolder::delete($tmpMod);
        }
//        JFolder::create($tmpMod);
//        JFolder::create($tmpComp.DS."admin");
//        JFolder::copy(JPATH_ADMINISTRATOR.DS."components".DS."com_".$prj->component,$tmpMod);
        JFolder::copy(JPATH_SITE.DS."modules".DS."mod_".$prj->component,$tmpMod);
//        JFile::write($tmpMod.DS."manifest.xml",$prj->manifest);

        jimport( 'joomla.filesystem.archive' );

//        $path = '/path/to/your/directory/';
        $this->load->library("zip");
//        $this->load->library('MY_Zip');
        $this->load->helper('download');

        $path = $tmpMod.DS;
        $folder_in_zip = "";

        $this->zip->add_dir($folder_in_zip);  // Create folder in zip
        $this->zip->get_files_from_folder($path, $folder_in_zip);

        $this->zip->download('mod_'.$prj->component.'.zip');

//        $this->zip->read_dir($tmpComp.DS);
//        $zip_file = $this->zip->get_zip();
        JFile::write($tmpDir.DS.'mod_'.$prj->component.'.zip',$zip_file);
//        force_download('com_'.$prj->component.'.zip', $zip_file);

//        $this->zip->download('com_'.$prj->component.'.zip');
//        $tar=JArchive::create($tmpComp.".gz",$tmpDir.DS."tmp".$prj->component,'gz','',$tmpComp);

//        $this->zip->download('com_'.$prj->component.'.zip');
        xRedirect("index.php?option=com_xcideveloper", "Enjoy next project");
    }

    function cancleNewProject(){
        xRedirect('index.php?option=com_xcideveloper',"Project Not Saved","notice");
    }


    function saveNewComponent(){
        jimport('joomla.filesystem.file');
        $this->load->model('mod_creator');
        $safefoldername = JFile::makeSafe($this->input->get("componentName"));
        if($safefoldername == ""){
            xRedirect("index.php?option=com_xcideveloper","Module Name is not accepted. Please user variable name rules","error");
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

        if(!$this->mod_creator->createNewComponent($safefoldername,$prjDetails,$prjConfig))
                xRedirect("index.php?option=com_xcideveloper","Component Already Exists.. Either Uninstall it or remove directory","error");


        xRedirect("index.php?option=com_xcideveloper","Component Created and Registered, Start developing or managing the component");
    }

    function removeProject(){
        $this->db->where("id",$this->input->get("xprjid"));
        $this->db->delete("xcideveloper_projects");
        xRedirect("index.php?option=com_xcideveloper","XCI project removed but NOT UNISTALLED, uninstall it manually from joomla system");
    }

    function saveNewModule(){
        jimport('joomla.filesystem.file');
        $this->load->model('mod_creator');
        $safefoldername = JFile::makeSafe($this->input->get("moduleName"));
        if($safefoldername == ""){
            xRedirect("index.php?option=com_xcideveloper","Module Name is not accepted. Please user variable name rules","error");
        }

        $prjDetails=array(
                'version' => $this->input->get('version'),
                'name'=>$this->input->get('moduleTitle'),
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
                'ModuleSide'=>$this->input->get("ModuleSide")
        );

        if(!$this->mod_creator->createNewModule($safefoldername,$prjDetails,$prjConfig))
                xRedirect("index.php?option=com_xcideveloper","Component Already Exists.. Either Uninstall it or remove directory","error");


        xRedirect("index.php?option=com_xcideveloper","Component Created and Registered, Start developing or managing the component");
    }

}
?>