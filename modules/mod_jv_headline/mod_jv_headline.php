<?php
/**
 * @package JV Headline module for Joomla! 1.5
 * @author http://www.ZooTemplate.com
 * @copyright(C) 2010- ZooTemplate.com
 * @license PHP files are GNU/GPL
**/

defined('_JEXEC') or die('Restricted access');// no direct access
require_once(dirname(__FILE__).DS.'helper.php');

global $moduleId, $cache_time;
$moduleId 		= $module->id;
$cache_time		= $params->get('cache_time');
$layoutStyle 	= $params->get('layout_style');
$slideDelay 	= trim($params->get('timming'));
$jvCommon 		= new modJVHeadlineCommonHelper($params);

switch($layoutStyle)
{
	case "jv_slide1":
		$list_slidecontent = $jvCommon->getSlideContent($params);
		
		if($params->get('content_type') == 'content') $list_slidecontent = $jvCommon->getSlideContent($params);
		else $list_slidecontent = $jvCommon->getItemsByK2($params);
		
		if(count($list_slidecontent))
		{	
			$height 	= $params->get('jv_news_height');
			$showthumb 	= trim($params->get('showthumb')); //Show Image Thumbnail
			$thumbsize 	= trim($params->get('news_thumbsize')); //Thumbnail Size
			$timming 	= trim($params->get('timming'));  //Time to rollover content
			$autorun 	= trim($params->get('news_autorun')); //Autorun
			
			if($autorun == 1) $autorun = 'true'; 
			else $autorun = 'false';
			
			require(JModuleHelper::getLayoutPath('mod_jv_headline'));
		}
		break;
		
	case "jv_slide2":
		$moduleHeight 	= $params->get('jveoty_height');
		$autoRun 		= $params->get('jveoty_autorun');		
		
		if($params->get('content_type') == 'content') $slides = $jvCommon->getSlideContent($params);
		else $slides = $jvCommon->getItemsByK2($params);
		
		if(count($slides))require(JModuleHelper::getLayoutPath('mod_jv_headline','jv_eoty'));
		break;
		
	case "jv_slide3":
		$moduleHeight 	= $params->get('jv_lago_height');
		$css_width 		= 'width:'.$params->get('jv_lago_main_width').'px';
		$verticalStyle 	= $params->get('lago_animation');
		
		$css_slidebar_width = 'width:'.$params->get('jv_lago_slidebar_width').'px';
		$css_height 		= 'height:'.$moduleHeight.'px';
		$css_item_heigth 	= 'height:'.$params->get('lago_hitem_sliderbar').'px';
		
		$divHeadLine 	= "jv_vheadline".$moduleId;
		$slideOuter	 	= "#slide_outer".$moduleId." div.slide";
		$slideBarItem 	= '#jv_pagislide'.$moduleId." ul.nav_slideitems li.nav_item";
		$slide_width 	= $params->get('jv_lago_main_width');
		$image_width 	= $params->get('lago_thumb_width');
		$image_height 	= $params->get('lago_thumb_height');
		$showButNext 	= $params->get('lago_show_next');		
		
		if($params->get('content_type') == 'content') $slides = $jvCommon->getSlideContent($params);
		else $slides = $jvCommon->getItemsByK2($params);
		
		if(count($slides)) require(JModuleHelper::getLayoutPath('mod_jv_headline','jv_lago'));		
		break;
		
	case "jv_slide4":
		$moduleWidth 	= ($params->get("jv_sello2_width"));
		$moduleHeight 	= $params->get('jv_sello2_height');		
		$showReadmore 	= $params->get('sello2_readmore',1);
		$showButNext 	= $params->get('sello2_show_next');
		$number_items_per_line =($params->get("sello2_no_items_per_line", "2"));
		
		if($params->get('content_type') == 'content') $list = $jvCommon->getSlideContent($params);
		else $list = $jvCommon->getItemsByK2($params);	
		if(count($list)) require(JModuleHelper::getLayoutPath('mod_jv_headline','jv_sello2'));
		break;
		
	case "jv_slide5":
		$height 		= $params->get('jv_maju_height');
		$isReadMore 	= $params->get('maju_readmore');
		$moduleWidth 	= $params->get('jv_maju_width');
		$moduleHeight 	= $params->get('jv_maju_height');
		$imgWidth 		= $params->get('maju_thumb_width');
		$imgHeight 		= $params->get('maju_thumb_height');		
		$showButNext 	= $params->get('maju_show_next');
		
		if($params->get('content_type') == 'content') $list = $jvCommon->getSlideContent($params);
		else $list = $jvCommon->getItemsByK2($params);	
		if(count($list)) require(JModuleHelper::getLayoutPath('mod_jv_headline','jv_maju'));
		break;
		
	case "jv_slide6":
		$moduleWidth 	= $params->get('jv_sello1_width');		
		$imgSlideWidth 	= $params->get('sello1_imgslide_width');
		$imgSlideHeight = $params->get('sello1_imgslide_height');
		$showButNext 	= $params->get('sello1_show_next');
		
		if($params->get('content_type') == 'content') $list = $jvCommon->getSlideContent($params);
		else $list = $jvCommon->getItemsByK2($params);
		
		$isReadMore 	= $params->get('sello1_readmore');
		
		if(count($list)) require(JModuleHelper::getLayoutPath('mod_jv_headline','jv_sello1'));
		break;
		
	case "jv_slide7":
		$mainModWidth 	= $params->get('jv7_main_width');
		$mainModHeight 	= $params->get('jv7_height');
		$isReadMore 	= $params->get('jv7_readmore');
		$showButNext 	= $params->get('jv7_show_next');
		$jvSlide7Helper = new modJVSlide7($params);
		
		if($params->get('content_type') == 'content') $list = $jvSlide7Helper->getSlideContent($params);
		else $list = $jvSlide7Helper->getItemsByK2($params);	
		if(count($list)) require(JModuleHelper::getLayoutPath('mod_jv_headline','slideshow7'));
		break;
		
	case "jv_slide8":
		$isReadMore 	= $params->get('pedon_readmore');
		$moduleWidth 	= $params->get('jv_pedon_width');
		$moduleHeight 	= $params->get('jv_pedon_height');
		$imgWidth 		= $params->get('pedon_thumb_width');
		$imgHeight 		= $params->get('pedon_thumb_height');		
		$showButNext 	= $params->get('pedon_show_next');
		
		if($params->get('content_type') == 'content') $list = $jvCommon->getSlideContent($params);
		else $list = $jvCommon->getItemsByK2($params);	
		if(count($list)) require(JModuleHelper::getLayoutPath('mod_jv_headline','jv_pedon'));
		break;	
		
	case "jv_slide9":
		$moduleHeight 	= $params->get('jv9_main_height');
		$moduleWidth 	= $params->get('jv9_main_width');
		$thumbWidth 	= $params->get('jv9_expand_width');
		$thumbHeight 	= $params->get('jv9_main_height');
		$descHeight 	= $params->get('jv9_height_desc',80);
		$expandWidth 	= $params->get('jv9_expand_width',700); 
		
		if($params->get('content_type') == 'content') $list = $jvCommon->getSlideContent($params);
		else $list = $jvCommon->getItemsByK2($params);		
		if(count($list)) require(JModuleHelper::getLayoutPath('mod_jv_headline','jv_boro'));		
		break;
	case "jv_slide10":
		$isReadMore = $params->get('zt_flow_readmore');
		$moduleWidth = $params->get('zt_flow_width');
		$moduleHeight = $params->get('zt_flow_height');
		$imgWidth = $params->get('zt_flow_thumb_width');
		$imgHeight = $params->get('zt_flow_thumb_height');		
		$showButNext = $params->get('zt_flow_show_next');
		if($params->get('content_type') == 'content') $list = $jvCommon->getSlideContent($params);
		else $list = $jvCommon->getItemsByK2($params);		
		if(count($list)) require(JModuleHelper::getLayoutPath('mod_jv_headline','zt_flow'));		
		break; 
}
?>