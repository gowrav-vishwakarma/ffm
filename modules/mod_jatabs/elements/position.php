<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementPosition extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Position'; 

	function fetchElement($name, $value, &$node, $control_name)
	{
		$options = $this->getPositions();

		$arrOpt = array();
		for($i=0; $i < count($options); $i++){
			$arrOpt[$i]['keys'] = $arrOpt[$i]['value'] = $options[$i]->position;
		}
		array_unshift($arrOpt, JHTML::_('select.option', '0', '- '.JText::_('Select position').' -', 'keys', 'value'));
		return JHTML::_('select.genericlist',  $arrOpt, ''.$control_name.'['.$name.']', 'class="inputbox"', 'keys', 'value', $value, $control_name.$name );
	}
	
	function getPositions()
	{
		$db =& JFactory::getDBO();
		
		$query = 'SELECT DISTINCT position'
		. ' FROM #__modules AS a'
		. ' WHERE a.published = 1'
		. ' ORDER BY a.position'
		;
		$db->setQuery( $query );
		$db->getQuery();
		$options = $db->loadObjectList();

		return $options;
	}
	
}