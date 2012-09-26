<?php
/**
 * @package ZT Drill Down module for Joomla! 1.5
 * @author http://www.ZooTemplate.com
 * @copyright(C) 2010- ZooTemplate.com
 * @license PHP files are GNU/GPL
**/
// no direct access
defined('_JEXEC') or die ('Restricted access');

class JElementK2category extends JElement
{
    /**
     * @access private
     */
	var	$_name = 'k2category';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$db = &JFactory::getDBO();
		
		if( !is_dir( JPATH_ADMINISTRATOR.'/components/com_k2' ) ) return JText::_('K2 is not installed');
		
		$query = 'SELECT m.* FROM #__k2_categories m WHERE published=1 AND trash = 0 ORDER BY parent, ordering';
		$db->setQuery( $query );
		$mitems = $db->loadObjectList();
		$children = array();
		if ( $mitems )
		{
			foreach ( $mitems as $v )
			{
				$pt 	= $v->parent;
				$list 	= @$children[$pt] ? $children[$pt] : array();
				array_push( $list, $v );
				$children[$pt] = $list;
			}
		}
		$list 		= JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0 );
		$mitems 	= array();
		$mitems[] 	= JHTML::_('select.option', '0', JText::_('---------- Select All ----------'));
		foreach ( $list as $item ) {
			$mitems[] = JHTML::_('select.option',  $item->id, $item->treename );
		}
		
		$output= JHTML::_('select.genericlist',  $mitems, ''.$control_name.'['.$name.'][]', 
						'class="inputbox" style="width:100%;" multiple="multiple" size="10"', 'value', 'text', $value );
		return $output;
	}
	
}
