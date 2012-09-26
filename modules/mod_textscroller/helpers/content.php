<?php
/*
* @package		mod_textscroller
* @copyright	Copyright (C) 2011 Emir Sakic, http://www.sakic.net. All rights reserved.
* @license		GNU/GPL, see LICENSE.TXT
*
* This program is free software; you can redistribute it and/or modify it
* under the terms of the GNU General Public License as published by the
* Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
* 
* This header must not be removed. Additional contributions/changes
* may be added to this header as long as no information is deleted.
*/

// no direct access
defined('_JEXEC') or die;

class modTextScrollerContentHelper
{
	function get(&$id, $params) {
	
		$text_type = $params->get( 'text_type', 'both' );
		
		//get database
		$db		= JFactory::getDbo();
		
		if (version_compare(JVERSION,'1.6.0','ge')) {
			$query	= $db->getQuery(true);
			$query->select('*');
			$query->from('#__content');
			$query->where('id = '.$id);
		} else {
			$query = "SELECT * FROM #__content WHERE id = $id";
		}

		$db->setQuery($query);
		$row = $db->loadObject();
		
		if ($text_type=='introtext') {
			$text = $row->introtext;
		} else if ($text_type=='fulltext') {
			$text = $row->fulltext;
		} else {
			$text = $row->introtext.$row->fulltext;
		}

		return $text;
	}
}