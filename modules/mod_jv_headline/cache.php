<?php
/**
 * @package JV News Module for Joomla! 1.5
 * @author http://www.ZooTemplate.com
 * @copyright (C) 2010- ZooTemplate.com
 * @license PHP files are GNU/GPL
**/

define( 'DS', DIRECTORY_SEPARATOR);
$rootFolder = explode(DS,dirname(__FILE__));
//current level in diretoty structure
$currentfolderlevel = 2;
array_splice($rootFolder, -$currentfolderlevel);
$base_folder = implode(DS,$rootFolder);

if(is_dir($base_folder.DS.'libraries'.DS.'joomla'))
{
	define('_JEXEC', 1);
	define('JPATH_BASE',implode(DS,$rootFolder));
	require_once(JPATH_BASE . DS .'includes'. DS .'defines.php');
	require_once(JPATH_BASE . DS .'includes'. DS .'framework.php');
	require_once(JPATH_BASE . DS .'libraries/joomla/factory.php');
	require_once(JPATH_BASE . DS .'libraries/joomla/html/parameter.php');
	jimport('joomla.filesystem.file');
	require_once(JPATH_SITE . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php');
	
	$mainframe =& JFactory::getApplication('site');
	$mainframe->initialise();
	
	$mid 	= JRequest::getVar('mid');
	$db		= JFactory::getDBO();
	$query	= "SELECT params FROM #__modules WHERE id = ". (int)$mid;
	$db->setQuery($query);
	$row	= $db->loadResult();
	
	$params 		= new JParameter($row);
	$layoutStyle 	= $params->get('layout_style');
	$thumbpath		= '';
	switch($layoutStyle)
	{
		case "jv_slide4":
			$thumbpath = $params->get('jv_sello2_thumbs');
			break;
		case "jv_slide3":		
			$thumbpath = $params->get('jv_lago_thumbs');	
			break;
		case "jv_slide6":
			$thumbpath = $params->get('jv_sello1_thumbs');	
			break;	
		case "jv_slide5":
			$thumbpath = $params->get('jv_maju_thumbs');
			break;
		case "jv_slide8":	
			$thumbpath = $params->get('jv_pedon_thumbs');
			break;
		case "jv_slide9":
			$thumbpath = $params->get('jv_jv9_main_thumbs');
			break;
		case "jv_slide7":
			$thumbpath = $params->get('jv_jv7_main_thumbs');	
			break;
		case "jv_slide2":
			$thumbpath = $params->get('jv_eoty_thumbs');
			break;
		case "jv_slide1":
			$thumbpath = $params->get('jv_news_thumbs');
			break;
	}
	$path = '../../'.$thumbpath . 'thumbs' . '/' . $mid . '/';
	if(is_dir($path))
	{
		@JFolder::delete($path);
		die('Clear cache successful !');
	}
	else
	{		
		$text = "Cache was clearing or path cache not correctly. (Current path: ".$thumbpath . 'thumbs' . '/' . $mid . '/'.").";
		die($text);
	}
}
?>