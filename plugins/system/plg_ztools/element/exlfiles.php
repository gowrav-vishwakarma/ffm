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

// Ensure this file is being included by a parent file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JElementExlfiles extends JElement
{

	var $_options = array();
	var $_type;
	
	function fetchElement($name, $value, &$node, $control_name)
	{
		$options = array ();
		
		if(strpos($name, "css") === false)
			$this->_type = "js";
		else
			$this->_type = "css";
		
		$str = '<div>[ <a href="" onclick="reload'.$this->_type.'(); return false;">Reload list</a> ]</div><div id="list-'.$this->_type.'" style="height:200px"><img src="'.JURI::root().'plugins/system/plg_ztools/element/loading.gif"/> Loading '.$this->_type.' files...</div>
				<script language="javascript">				
				window.addEvent("domready",function(){					
							var url="'.JURI::root().'plugins/system/plg_ztools/element/getdata.php?type='.$this->_type.'&path='.str_replace(DS, "/", JPATH_ROOT).'&name='.$name.'&value='.implode(",", (array)$value).'&control_name='.$control_name.'";	
							var a = new Ajax(url, {
								method: "get",
								onComplete: function(response){ $("list-'.$this->_type.'").setHTML(response);}
							}).request();
						});
				
				function reload'.$this->_type.'(){
							$("list-'.$this->_type.'").setHTML("<img src=\"'.JURI::root().'plugins/system/plg_ztools/element/loading.gif\"/> Loading '.$this->_type.' files...");
							var url="'.JURI::root().'plugins/system/plg_ztools/element/getdata.php?type='.$this->_type.'&path='.str_replace(DS, "/", JPATH_ROOT).'&name='.$name.'&value='.implode(",", (array)$value).'&control_name='.$control_name.'&reload=true";	
							var a = new Ajax(url, {
								method: "get",
								onComplete: function(response){ $("list-'.$this->_type.'").setHTML(response);}
							}).request();
						}
				</script>';
		return $str;
	}	
}
?>