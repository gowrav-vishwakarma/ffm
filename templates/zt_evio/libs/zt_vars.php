<?php
/**
* @version 1.5.x
* @package ZooTemplate Project
* @email webmaster@zootemplate.com
* @copyright (C) 2011 http://www.ZooTemplate.com. All rights reserved.
*/

/* 
 *DEFINE 
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

$ztconfig = new JConfig();
$menustyle = $this->params->get('zt_menustyle');
$ztTools = new ZT_Tools($this);
///-----------------------------------------------------///

$ztcolorstyle = "ZTEvioStyleCookieSite";

$get_ms 	= JRequest::getVar('menustyle');
$cookie_ms 	= $ztTools->get_cookie('ztmenustyle_evio');

$get_rtl 	= JRequest::getVar('direction');
$cookie_rtl = $ztTools->get_cookie('zt_rtl_evio');

if( $cookie_ms && $cookie_ms != "" )
	$menustyle = $cookie_ms;

if($get_ms){
	$menustyle = $get_ms;
	$ztTools->set_cookie('ztmenustyle_evio',$get_ms);
}

if($this->params->get('zt_rtl')) {
	$ztrtl = 'rtl';
} else {
	$ztrtl = 'ltr';
}

if( $cookie_rtl && $cookie_rtl != "" )
	$ztrtl = $cookie_rtl;

if($get_rtl && ($get_rtl == 'rtl' || $get_rtl == 'ltr') ) {
	$ztrtl = $get_rtl;
	$ztTools->set_cookie('zt_rtl_evio',$get_rtl);
}

/*
 * Behavior 
 */
JHTML::_('behavior.mootools');

/*
 * VARIABLES 
 */
$default_menu 	= $this->params->get('menutype');
//Fancy menu
$fancy 			= $this->params->get('fancy', 0);
$transition		= $this->params->get('transition', 'Fx.Transitions.linear');
$duration		= $this->params->get('duration', 500);
$xdelay			= $this->params->get('xdelay', 700);
$xduration		= $this->params->get('xduration', 2000);
$xtransition	= $this->params->get('xtransition', 'Fx.Transitions.Bounce.easeOut');

if(!$default_menu) $default_menu = 'mainmenu';

//Mobile block
$browser   = new Browser();
$myBrowser = $browser->isMobile();
$isMobile  = $browser->isMobile();
$getViewType    = JRequest::getVar('ismobile');
$cookieViewType = $ztTools->get_cookie('evio_ismobile');

if($getViewType != NULL){
	$myBrowser = $getViewType;
	$ztTools->set_cookie('evio_ismobile', $myBrowser);
} else if($cookieViewType && $cookieViewType != "") {
	$myBrowser = $cookieViewType;
} else {
	$ztTools->set_cookie('evio_ismobile', $myBrowser);
}

if($myBrowser) {
	$menustyle = "drill";
}
//End block

$menu = new MenuSystem($menustyle, $default_menu, $this->template, $ztrtl, $fancy, $transition, $duration, $xdelay, $xduration, $xtransition);

/* 
 *GZIP Compression
 */
$gzip  = ($this->params->get('gzip', 1)  == 0)?"false":"true";
///-----------------------------------------------------/// 
$showTools = $this->params->get('showtools',1);
/*
 *Auto Collapse Divs Functions
 */ 
$modLeft = $this->countModules('left');
$modRight = $this->countModules('right');

$modUser7 = $this->countModules('user7');
$modUser8 = $this->countModules('user8');
$modUser9 = $this->countModules('user9');
$modUser10 = $this->countModules('user10');


if(!$modLeft && !$modRight) {
	$zt_width = "-full";
} elseif(!$modRight) {
	$zt_width = "-left";
} elseif(!$modLeft) {
	$zt_width = "-right";
} else {
	$zt_width = "";
}

if(!$modUser7 && !$modUser8 && !$modUser9 && !$modUser10 ){
	$zt_positon= "zt-wrap4";
}
else{
	$zt_positon="";
}

$changecolor = '';

$changefont = '';

?>