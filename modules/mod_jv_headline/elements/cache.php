<?php
/**
 * @package JV Headline module for Joomla! 1.5
 * @author http://www.ZooTemplate.com
 * @copyright (C) 2010- ZooTemplate.com
 * @license PHP files are GNU/GPL
**/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a category element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JElementCache extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'cache';

	function fetchElement($name, $value, &$node, $control_name)
	{				
		$mid	= JRequest::getVar('cid');
		if(is_array($mid)) $mid = $mid[0];
		if($mid == 0) $mid = JRequest::getVar('id');
		
		$script	= '<script language="javascript" type="text/javascript">
						function clearCache()
						{
							var linkurl = "../modules/mod_jv_headline/cache.php?mid='.$mid.'";
							new Ajax(linkurl, {method:"post", 
								onSuccess: function(result){
										alert(result);
								}
							}).request();
						}
				   </script>';
				   
		$text	= '<a href="javascript:void(0)" onClick="javascript: clearCache()">Clear Cache</a>';
		return $text . $script;
	}
}
?>