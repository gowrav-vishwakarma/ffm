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
 *---------------------------------------------------------------
 * PHP ERROR REPORTING LEVEL
 *---------------------------------------------------------------
 *
 * By default CI runs with error reporting set to ALL.  For security
 * reasons you are encouraged to change this to 0 when your site goes live.
 * For more info visit:  http://www.php.net/error_reporting
 *
 */
	error_reporting(E_ALL);

/*
 *---------------------------------------------------------------
 * Manage view regarding things with ci.. use joomla views and format pattern
 *---------------------------------------------------------------
 */

//        $xview=JRequest::getVar('view',trim(JRequest::getVar('option'),'com_'));
//        $xformat = JRequest::getVar('format','html');
//        $xlayout=  JRequest::getVar('layout','default');
//
//        define('xFORMAT', $xformat);
//        define('xVIEWPATH', JPATH_COMPONENT."/views/".$xview ."/");
//        define('xVIEW', $xview.".".$xformat);
//        define('xLAYOUT_VIEW',$xview."/tmpl/".$xlayout);


/*
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * folder then the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server.  If
 * you do, use a full server path. For more info please see the user guide:
 * http://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 *
 */
        $GLOBALS['params']=$params;
        $GLOBALS['xCICurrentExtension']="mod_{component}";
        $GLOBALS['xIMModule']=true;
        global $xCICurrentExtension;
	$application_folder = dirname(__FILE__);
        $GLOBALS['APPPATH']=$application_folder."/";
/*
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" folder.
 * Include the path if the folder is not in the same  directory
 * as this file.
 *
 */

if (is_dir(JPATH_ROOT . DS . "system"))
    $system_path = JPATH_ROOT . DS . "system";
elseif (is_dir($application_folder . DS . "system"))
    $system_path = $application_folder . DS . "system";


/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the routes.php file.
 * You can, however, force a custom routing by hard-coding a
 * specific controller class/function here.  For most applications, you
 * WILL NOT set your routing here, but it's an option for those
 * special instances where you might want to override the standard
 * routing in a specific front controller that shares a common CI installation.
 *
 * IMPORTANT:  If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller.  Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * Un-comment the $routing array below to use this feature
 *
 */
	// The directory name, relative to the "controllers" folder.  Leave blank
	// if your controller is not in a sub-folder within the "controllers" folder
	// $routing['directory'] = '';

	// The controller class file name.  Example:  Mycontroller.php
//	 $routing['controller'] = 'xciwelcome';

	// The controller function you wish to be called.
	// $routing['function']	= '';


/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * Un-comment the $assign_to_config array below to use this feature
 *
 */
	// $assign_to_config['name_of_config_item'] = 'value of config item';



// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------




/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */
	if (realpath($system_path) !== FALSE)
	{
		$system_path = realpath($system_path).'/';
	}

	// ensure there's a trailing slash
	$system_path = rtrim($system_path, '/').'/';

	// Is the system path correct?
	if ( ! is_dir($system_path))
	{
		exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
	}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
	// The name of THIS file
	if(! defined($xCICurrentExtension.'SELF')) define($xCICurrentExtension.'SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	// The PHP file extension
	if(! defined($xCICurrentExtension.'EXT')) define($xCICurrentExtension.'EXT', '.php');
        if(!defined('EXT')) define('EXT' ,'.php');

	// Path to the system folder
	if(! defined($xCICurrentExtension.'BASEPATH')) define($xCICurrentExtension.'BASEPATH', str_replace("\\", "/", $system_path));
        if(!defined('BASEPATH')) define('BASEPATH', str_replace("\\", "/", $system_path));

	// Path to the front controller (this file)
	if(! defined($xCICurrentExtension.'FCPATH')) define($xCICurrentExtension.'FCPATH', str_replace(constant($xCICurrentExtension.'SELF'), '', __FILE__));

	// Name of the "system folder"
	if(! defined($xCICurrentExtension.'SYSDIR')) define($xCICurrentExtension.'SYSDIR', trim(strrchr(trim(constant($xCICurrentExtension.'BASEPATH'), '/'), '/'), '/'));


	// The path to the "application" folder
	if (is_dir($application_folder))
	{
		if(! defined($xCICurrentExtension.'APPPATH')) define($xCICurrentExtension.'APPPATH', $application_folder.'/');
	}
	else
	{
		if ( ! is_dir(BASEPATH.$application_folder.'/'))
		{
			exit("Your application folder path does not appear to be set correctly. Please open the following file and correct this: ".SELF);
		}

		if(! defined($xCICurrentExtension.'APPPATH')) define($xCICurrentExtension.'APPPATH', BASEPATH.$application_folder.'/');
	}

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 *
 */

require constant($xCICurrentExtension.'BASEPATH').'core/CodeIgniter'.constant($xCICurrentExtension.'EXT');

/* End of file index.php */
/* Location: ./index.php */