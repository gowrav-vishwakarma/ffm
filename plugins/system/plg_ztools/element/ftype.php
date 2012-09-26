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
class JElementFType extends JElement
{
	
	/*
	 * Category name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'ftype';
	
	/**
	 * fetch Element 
	 */
	function fetchElement($name, $value, &$node, $control_name)
	{
		$option = array('global'=>'Global', 'menu'=>"Menu", 'optimize'=>'Optimize', 'advanced'=>'Advanced');
		$value	= (isset($value)) ? $value : 'global';
		
		$html = '<div class="nav-main">';
		foreach($option as $key=>$val) {
			$html .= '<div id="nav-'.$key.'" class="nav-item'.(($value == $key) ? ' nav-active' : '').'">';
			$html .= '<a href="javascript:void(0);" onClick="javascript:show(\''.$key.'\')"><div class="icon-'.$key.'"><h3>'.$val.'</h3></div></a>';
			$html .= '</div>';
		}
		$html .= '</div>';
		$html .= '<script language="javascript" type="text/javascript">window.addEvent(\'load\', function(){show(\''.$value.'\')});</script>';
		return $html;
	}
}
?>