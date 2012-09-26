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
defined('_JEXEC') or die('Restricted access');

$article_id = intval( $params->get( 'article_id', 32 ) );
$width = $params->get( 'width', '100%' );
if (!stristr($width,'%')) {
	$width .= 'px';
}
$height = intval( $params->get( 'height', 200 ) );
$autoplay = intval( $params->get( 'autoplay', 1 ) );
$time_down = intval( $params->get( 'time_down', 20 ) );
$time_up = intval( $params->get( 'time_up', 200 ) );
$pause_time = intval( $params->get( 'pause_time', 500 ) );
$scrollbar = intval( $params->get( 'scrollbar', 0 ) );
$mouseover_pause = intval( $params->get( 'mouseover_pause', 1 ) );

$relpath = 'modules/mod_textscroller';
$path = JURI::root(true).'/'.$relpath;

$css = $relpath.'/assets/css/style.css';

$document =& JFactory::getDocument();

if (!defined('TEXTSCRL_SCRIPT')) {
	define('TEXTSCRL_SCRIPT', 1);
	if (version_compare(JVERSION,'1.6.0','ge')) {
		JHtml::_('behavior.framework', true);
	} else {
		JHTML::_('behavior.mootools');
	}
	$document->addScript($path.'/assets/js/script.js');
	$document->addStyleSheet($css);
}

$document->addScriptDeclaration("
	window.addEvent('domready', function() {
		TextScroller(Array($module->id, ".$autoplay.", ".$time_down.", ".$time_up.", ".$pause_time.", ".$mouseover_pause."));
	});
");

$content = '';

require_once( dirname(__FILE__).'/helpers/content.php' );
$text = modTextScrollerContentHelper::get($article_id, $params);

$class = 'tContainer';
if ($scrollbar) {
	$class .= ' scrollshow';
}

$content .= '<div id="tContainer'.$module->id.'" class="'.$class.'" style="width: '.$width.'; height: '.$height.'px;">';
$content .= $text;
$content .= '</div>';

?>