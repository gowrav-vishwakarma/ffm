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
class JElementPositions extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Positions';

	function fetchElement($name, $value, &$node, $control_name)
	{	
		$db 		= &JFactory::getDBO();
		$query 		= "SELECT DISTINCT position FROM #__modules ORDER BY position ASC";
		$db->setQuery($query);
		$groups 	= $db->loadObjectList();
		$groupHTML 	= array();
		
		if($groups && count ($groups))
		{
			foreach($groups as $v=>$t)
			{
				$groupHTML[] = JHTML::_('select.option', $t->position, $t->position);
			}
		}
		
		$lists = JHTML::_('select.genericlist', $groupHTML, "params[".$name."][]", ' multiple="multiple"  size="10" ', 'value', 'text', $value);
		
		return $lists; 
	}
} 