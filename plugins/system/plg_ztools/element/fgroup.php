<?php 
/**
 * @package ZTools Plugin for Joomla! 1.5
 * @author http://www.ZooTemplate.com
 * @copyright(C) 2010- ZooTemplate.com
 * @license PHP files are GNU/GPL
**/
defined('_JEXEC') or die('Restricted access');
/**
 * Get a collection of categories
 */
class JElementFgroup extends JElement
{
	
	/*
	 * Category name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'fgroup';
	
	/**
	 * fetch Element 
	 */
	function fetchElement($name, $value, &$node, $control_name)
	{
		$mediaPath = str_replace("administrator/", "", JURI::base()).'plugins/system/plg_ztools/assets/';
		JHTML::stylesheet('form.css', $mediaPath );	
		
		$attributes = $node->attributes();
		$class 	= isset($attributes['group']) && trim($attributes['group']) == 'end' ? 'zt-end-group' : 'zt-group'; 
		$title	= isset($attributes['title']) ? JText::_($attributes['title']):'Group';
		$title	= isset($attributes['title']) ? JText::_($attributes['title']):'';
		$for 	= isset($attributes['for']) ? $attributes['for']:'';
		$string = '<div  class="'.$class.'" title="'.$for.'">'.$title.'</div>';
		
		if(!defined('ADDED_TIME'))
		{
			$string .= '<input type="hidden" class="text_area" value="'.time().'" id="paramsmain_added_time" name="params[added_time]">';
			define('ADDED_TIME', 1);
			JHTML::script('form.js', $mediaPath);
		}
		return $string;
	}
}
?>