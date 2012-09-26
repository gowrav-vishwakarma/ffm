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
class JElementRainbow extends JElement
{
	
	/*
	 * Category name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'rainbow';
	
	/**
	 * fetch Element 
	 */
	function fetchElement($name, $value, &$node, $control_name)
	{
		$uri = str_replace(DS,"/",str_replace(JPATH_SITE, JURI::base(), dirname(__FILE__)));
		$uri = str_replace("/administrator/", "", $uri);
		$uri = str_replace("/element", "/assets/", $uri);
		
		if(!defined('ZT_RAINBOW'))
		{
			define('ZT_RAINBOW', 1);
			$document 	= &JFactory::getDocument();			
			
			$document->addStyleSheet($uri . 'rainbow.css');
			$document->addScript($uri . 'rainbow.js');
		}
		
		$html  = '<input id="'.$name.'" name="params['.$name.']" type="text" size="20" value="'.$value.'" style="background-color:'.$value.'" /> ';
		$html .= '<img id="rainbow_'.$name.'" src="'.$uri.'images/rainbow.png" alt="[r]" width="16" height="16" align="absmiddle" />';
		
		$html .= '<script language="javascript" type="text/javascript">';
		$html .= 'window.addEvent("load", function(){
			new MooRainbow("rainbow_'.$name.'", {
				id: "rainbow_'.$name.'",
				wheel: true,
				imgPath: "'.$uri.'images/",
				onChange: function(color) {
					$("'.$name.'").value = color.hex;
					$("'.$name.'").setStyle("background-color", color.hex);
				}
			});
		});';
		$html .= '</script>';
		
		return $html;
	}
}
?>