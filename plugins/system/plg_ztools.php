<?php
/*
# ------------------------------------------------------------------------
# ZT Menu Parameters plugin for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright(C) 2008-2011 www.zootemplate.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: ZooTemplate
# Websites: http://www.zootemplate.com
# ------------------------------------------------------------------------
*/

defined('_JEXEC') or die();
jimport('joomla.plugin.plugin');
jimport('joomla.application.module.helper');
// Import library dependencies
jimport('joomla.event.plugin');
jimport('joomla.filesystem.file');
/**
 * ZTPopup Content Plugin
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 		1.5
 */
require_once(dirname(__FILE__) . DS . 'plg_ztools' . DS . 'define.php');
require_once(dirname(__FILE__) . DS . 'plg_ztools' . DS . 'common.php');
require_once(dirname(__FILE__) . DS . 'plg_ztools' . DS . 'libs' . DS . 'library.php');

class plgSystemPlg_ZTools extends JPlugin
{
	/** @var object $_modalObject  */
	var $_params 		= null;
	var $_dbValue 		= null;
	var $_pluginLibPath = null;
	var $_cache 		= null;
	var $_content 		= null;
	var $_k2	 		= null;
	var $_components	= null;
	
	function plgSystemPlg_ZTools(&$subject)
	{
		$this->__construct($subject);
	}
	
	function __construct(&$subject)
	{
		parent::__construct($subject);
		// Load plugin parameters
		$this->_plugin 			= JPluginHelper::getPlugin('system', 'plg_ztools');
		$this->_params 			= new JParameter($this->_plugin->params);
		$this->_pluginLibPath 	= JPATH_PLUGINS.DS."system".DS."plg_ztools".DS;
		$this->loadLanguage('plg_'.$this->_plugin->type.'_'.$this->_plugin->name, JPATH_ADMINISTRATOR);
		//Get exclude categories
		$components	= $this->_params->get('components', '');
		$content	= $this->_params->get('content_category', '');
		$k2			= $this->_params->get('k2_category', '');
		
		$this->_components 	= (is_array($components)) ? $components : array($components);
		$this->_content		= (is_array($content)) ? $content : array($content);
		$this->_k2			= (is_array($k2)) ? $k2 : array($k2);
		
		$config =& JFactory::getConfig();
		$options = array(
			'cachebase' 	=> JPATH_BASE.DS.'cache',
			'defaultgroup' 	=> 'page',
			'lifetime' 		=> $this->_params->get('gzip_cachetime', 15) * 60,
			'browsercache'	=> ($this->_params->get('gzip_browsercache', 0)) ? true : false,
			'caching'		=> false,
			'language'		=> $config->getValue('config.language', 'en-GB')
		);

		jimport('joomla.cache.cache');
		$this->_cache =& JCache::getInstance('page', $options);
	}
	
	function checkCurrentComp()
	{
		global $mainframe, $option;
		$return = true;
		$option = JRequest::getVar('option');
		$view	= JRequest::getVar('view');
		
		if(in_array($option, $this->_components)) {
			$return = false;
		}
		if(in_array($option.'.'.$view, $this->_components)) {
			$return = false;
		}
		
		return $return;		
	}
	
	function checkCurrentPage()
	{
		global $mainframe, $db, $_PROFILER, $option;
		$db		= &JFactory::getDBO();
		$return = true;
		$option = JRequest::getVar('option');
		$view	= JRequest::getVar('view');
		
		switch($option)
		{
			case "com_content":
				if($view == 'article') {
					$id 	= JRequest::getVar('id');
					$query	= "SELECT catid FROM #__content WHERE id = ".intval($id);
					$db->setQuery($query);
					$cid	= $db->loadResult();
					
					if(in_array('0', $this->_content)) $return = false;
					if(in_array($cid, $this->_content)) $return = false;
				}
			break;
			case "com_k2":
				if($view == 'item') {
					$id 	= JRequest::getVar('id');
					$query	= "SELECT catid FROM #__k2_items WHERE id = ".intval($id);
					$db->setQuery($query);
					$cid	= $db->loadResult();
					
					if(in_array('0', $this->_k2)) $return = false;
					if(in_array($cid, $this->_k2)) $return = false;
				}
			break;
		}
		
		return $return;
	}
	
	function onAfterInitialise()
	{
		if($this->_params->get('gzip_browsercache', 0))
		{
			global $mainframe, $_PROFILER;
			$user = &JFactory::getUser();
	
			if($mainframe->isAdmin() || JDEBUG){return;}
	
			if(!$user->get('aid') && $_SERVER['REQUEST_METHOD'] == 'GET' 
			&& $this->checkCurrentPage() && $this->checkCurrentComp()){$this->_cache->setCaching(true);}
			
			$data  = $this->_cache->get();

			if($data !== false)
			{
				$token	= JUtility::getToken();
				$search = '#<input type="hidden" name="[0-9a-f]{32}" value="1" />#';
				$replacement 	= '<input type="hidden" name="'.$token.'" value="1" />';
				$data 			= preg_replace( $search, $replacement, $data );
				
				//Replace src of images
				$image = '/<img(.*?)src="(.*?)"/i';
				preg_match_all($image, $data, $matchs);
				
				$replaced = array();
				if(count($matchs[2]))
				for($i = 0; $i < count($matchs[2]); $i++) {
					$link 	= $matchs[2][$i];
					$spacer = $matchs[1][$i];
					if(!(strpos($link, "http://") !== FALSE) && !(strpos($link, "../") !== FALSE) 
					&& $link[0] != '/' && $link[0] != '.' && !in_array($link, $replaced)) {
						$data = str_replace('<img'.$spacer.'src="'.$link.'"', '<img'.$spacer.'src="'.JURI::base().$link.'"', $data);
					}
					$replaced[] = $link;
				}
				
				//Replace src of link
				$url = '/<a(.*?)href="(.*?)"/i';
				preg_match_all($url, $data, $matchs);
				
				$replaced = array();
				if(count($matchs[2]))
				for($i = 0; $i < count($matchs[2]); $i++) {
					$link   = $matchs[2][$i];
					$spacer = $matchs[1][$i];
					if(!(strpos($link, "http://") !== FALSE) && !(strpos($link, "../") !== FALSE)
					&& $link[0] != '/' && $link[0] != '.' && !in_array($link, $replaced)) {
						$data = str_replace('<a'.$spacer.'href="'.$link.'"', '<a'.$spacer.'href="'.JURI::base().$link.'"', $data);
					}
					$replaced[] = $link;
				}
				
				JResponse::setBody($data);
				echo JResponse::toString($mainframe->getCfg('gzip'));
	
				if(JDEBUG)
				{
					$_PROFILER->mark('afterCache');
					echo implode( '', $_PROFILER->getBuffer());
				}
	
				$mainframe->close();
			}
		}
	}
	
	function getSystemParams($xmlstring)
	{
		// Initialize variables
		$params	= null;
		$item	= $this->getDatabaseValue();
		
		if(isset($item->params))
			$params = new JParameter($item->params);
		else
			$params = new JParameter("");
			
		$xml =& JFactory::getXMLParser('Simple');
		
		if($xml->loadString($xmlstring)){
			$document =& $xml->document;
			$params->setXML($document->getElementByPath('state/params'));
		}
		
		return $params->render('params');
	}
	
	/**
	 * Popup prepare content method
	 *
	 * @param 	string		The body string content.
	 */
	 
	function replaceContent($bodyContent)
	{
		// Build HTML params area
		$xmlFile = $this->_pluginLibPath."params".DS."zttoolbar.xml";
		
		if(!file_exists($xmlFile))
		{
			return $bodyContent;
		}
		
		$str 		= "";
		$xmlFile 	= JFile::read($xmlFile);
		preg_match_all("/<params([^>]*)>([\s\S]*?)<\/params>/i", $xmlFile, $matches);
		
		foreach($matches[0] as $v)
		{
			$v = preg_replace("/group=\"([\s\S]*?)\"/i", '', $v);
			
			$xmlstring = '<?xml version="1.0" encoding="utf-8"?>
							<metadata>
								<state>
									<name>Component</name>
									<description>Component Parameters</description>';
			$xmlstring .= $v;
			$xmlstring .= '</state>
							</metadata>';
			preg_match_all("/label=\"([\s\S]*?)\"/i", $v, $arr);
			$str .= '</div><div class="panel">
				<h3 id="zttoolbar-page" class="jpane-toggler title">
				<span>'. $arr[1][0] .'</span></h3>
				<div class="jpane-slider content" style="border-top: medium none; border-bottom: medium none; overflow: hidden; padding-top: 0px; padding-bottom: 0px;">
				'.$this->getSystemParams($xmlstring)."</div></div>";
		}
		preg_match_all("/<div class=\"panel\">([\s\S]*?)<\/div>/i", $bodyContent, $arr);
		$bodyContent = str_replace($arr[0][count($arr[0])-1], $arr[0][count($arr[0])-1].$str, $bodyContent);
		return $bodyContent;
	}
	
	function onAfterRender()
	{
		global $mainframe;
		$document = &JFactory::getDocument();
		
		// Run only on edit menu
		if(JRequest::getVar("option") == "com_menus" && JRequest::getVar("task") == "edit" )
		{
			// HTML= Parser lib
			require_once(JPATH_PLUGINS.DS."system".DS."plg_ztools".DS."assets".DS."html_parser.php");
			
			if(!isset($this->_plugin)) return;
		
			$_body = JResponse::getBody();
			// Replace content
			$_body = $this->replaceContent($_body);
			
			if($_body)
			{
				JResponse::setBody($_body);
			}
		}
		
		//Load GZip
		if($mainframe->isSite() && $document->_type == 'html' && !$mainframe->getCfg('offline'))
		{
			ZTimport('plg_ztools.libs.ztgzip');
			$Gzip = new ZTGzip;
			
			if($document->params->get('gzip_optimize_css', 0)) $Gzip->optimizecss();
			
			if($document->params->get('gzip_optimize_js', 0)) $Gzip->optimizejs();
			
			if($document->params->get('gzip_optimize_html', 1)) $Gzip->optimizehtml();
			
			$type	= JRequest::getVar('type');
			$action = JRequest::getVar('action');
			if($type == 'plugin' && $action == 'clearCache')
				$Gzip->clearCache();
			
			//Store cache
			if($this->_params->get('gzip_browsercache', 0))
			{
				$user = &JFactory::getUser();
				if(!$user->get('aid')) {
					//We need to check again here, because auto-login plugins have not been fired before the first aid check
					$this->_cache->store();
				}
			}
		}
		else
		{
			$uri 	= str_replace(DS, "/", str_replace(JPATH_SITE, JURI::base(), dirname(__FILE__)));
			$uri 	= str_replace("/administrator/", "", $uri);
			$html 	= '<script language="javascript" type="text/javascript" 
			src="'.$uri.'/plg_ztools/assets/js/bt_clear_cache.js"></script>';
			$buffer = JResponse::getBody ();
			$buffer = preg_replace('/<\/head>/', $html . "\n</head>", $buffer);
			JResponse::setBody($buffer);						
		}
	}
	
	function getDatabaseValue()
	{
		$db = &JFactory::getDBO();
		$id = JRequest::getVar('cid', 0, '', 'array');
		$id = (int)$id[0];
		
		if($id == "") $id = 0;
		
		$query = "SELECT * FROM #__menu WHERE id = '".$id."'";
		
		$db->setQuery($query);
		return $db->loadObject();
	}	
}