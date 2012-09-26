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

/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
 
class JElementztparamhelper extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	 
	var	$_name = 'ztparamhelper';

	function fetchElement($name, $value, &$node, $control_name)
	{
		if(substr($name, 0, 1) == '@')
		{
			$name = substr($name, 1);
			if(method_exists($this, $name))
			{
				return $this->$name($name, $value, $node, $control_name);
			}
		}
		return; 
	}
	
	function fetchTooltip($label, $description, &$node, $control_name, $name)
	{
		return;
	}
	
	/**
	 * render title.
	 */
	 
	function title($name, $value, &$node, $control_name)
	{
		$_title			= (isset($node->_attributes['label'])) ? JText::_($node->_attributes['label']): '';
		$_description	= (isset($node->_attributes['description'])) ? JText::_($node->_attributes['description']) : '';
		$_url			= (isset($node->_attributes['url'])) ? $node->_attributes['url'] : '';
		$class			= (isset($node->_attributes['class'])) ? $node->_attributes['class'] : '';
		$group			= (isset($node->_attributes['group'])) ? $node->_attributes['group'] : '';
		$group			= $group ? "id='params$group-group'":"";
		
		if($_title)
		{
			$_title 	= html_entity_decode(JText::_($_title));
		}

		if($_description){$_description = html_entity_decode($_description);}
		
		if($_url){$_url = " <a target='_blank' href='{$_url}' >[".html_entity_decode(JText::_("Demo"))."]</a> ";}

		$html = '
		<h4 class="block-head '.$class.'" '.$group.'>'.$_title.$_url.'</h4>
		<div class="block-des '.$class.'">'.$_description.'</div>
		';

		return $html;
	}
	
	function radio($name, $value, &$node, $control_name)
	{
		$options = array();
		foreach($node->children() as $option)
		{
			$val	= $option->attributes('value');
			$text	= $option->data();
			$_url	= $option->attributes('url');
			
			if($_url){$_url = " <a target='_blank' href='{$_url}' >[".html_entity_decode(JText::_("Website"))."]</a> ";}
			
			$options[] = JHTML::_('select.option', $val, JText::_($text));
		}

		return JHTML::_('select.radiolist', $options, ''.$control_name.'['.$name.']', '', 'value', 'text', $value, $control_name.$name);
	}
	
	/**
	 * render js to control setting form.
	 */
	 
	function group($name, $value, &$node, $control_name)
	{
		$attributes = $node->attributes(); // echo '<pre>'.print_r($attributes); die;
		$groups 	= array();
		
		if(isset($attributes['value']) && $attributes['value'] != "")
		{
			$groups = preg_split("/[|]/", $attributes['value']);
		}
		
		if(!defined('_ZT_PARAM_HELPER'))
		{
			define('_ZT_PARAM_HELPER', 1);
			$uri = str_replace(DS,"/",str_replace(JPATH_SITE, JURI::base(), dirname(__FILE__)));
			$uri = str_replace("/administrator", "", $uri);
			
			JHTML::stylesheet('ztparamhelper.css', $uri."/");
			JHTML::script('ztparamhelper.js', $uri."/");
		}
?>
<script type="text/javascript">
		window.addEvent("domready", function(){
			<?php foreach($groups as $group):?>
			initztpramhelpergroup("<?php echo $group; ?>", { hideRow:<?php echo(isset($attributes['hiderow']) ? $attributes['hiderow']:false) ?>});
			<?php endforeach;?>
		});
</script>
<?php		
	return;
	}
	
	/**
	 * render js to control setting form for embeded.
	 */
	 
	function group2($name, $value, &$node, $control_name)
	{ 
		$attributes 	= $node->attributes(); // echo '<pre>'.print_r($attributes); die;
		$_title			=(isset($node->_attributes['label'])) ? JText::_($node->_attributes['label']): '';
		$_description	=(isset($node->_attributes['description'])) ? JText::_($node->_attributes['description']) : '';
				
		$groups = array();
		
		if(isset($attributes['value']) && $attributes['value'] != "")
		{
			$groups = preg_split("/[|]/", $attributes['value']);
		}
		
		$html = '';
		if(!defined('_ZT_PARAM_HELPER'))
		{
			define('_ZT_PARAM_HELPER', 1);
			$uri = str_replace(DS,"/",str_replace(JPATH_SITE, JURI::base(), dirname(__FILE__)));
			$uri = str_replace("/administrator", "", $uri);
			
			$html .= "<link href=\"$uri/ztparamhelper.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
			$html .= "<script type=\"text/javascript\" src=\"$uri/ztparamhelper.js\"></script>\n";
		}
		
		$html .= '<script type="text/javascript">';
		$html .= 'window.addEvent("domready", function(){';
		foreach($groups as $group){
			$html .= 'initztpramhelpergroup("'.$group.'", { hideRow:'.(isset($attributes['hiderow']) ? $attributes['hiderow']:false).' });';
		}
		$html .= '});</script>';
		if($_title) $html .= "<h4 class=\"block-head\">$_title</h4>";
		if($_description) $html .= "<div class=\"block-des\">$_description</div>";
		return $html;
	}	
}