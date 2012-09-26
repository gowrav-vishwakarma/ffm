<?php
/**
 * @package   ZOE Template Framework by ThemExpert
 * @version   2.5.0 June 01, 2010
 * @author    ThemExpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2010 ThemExpert LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 * 
 * This Framework uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 * 
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once(TEMPLATEPATH.DS.'lib'.DS.'php'.DS."tx.template.helper.php");
JHTML::_('behavior.mootools');
/*********************************************
*   hold all position for template
*******************************************/
$position= array(
    'roof'=>array('roof1','roof2','roof3','roof4'),
    'head'=>array('header1','header2','header3','header4'),
    'top'=>array('top1','top2','top3','top4'),
    'feature'=>array('feature1','feature2','feature3','feature4'),
    'menu'=>array('main-menu'),
    'maintop'=>array('maintop1','maintop2','maintop3'),
    'mainbottom'=>array('mainbottom1','mainbottom2','mainbottom3'),
    'bottom'=>array('bottom1','bottom2','bottom3','bottom4'),
    'footer'=>array('footer1','footer2','footer3','footer4')
);
//declear tempalte object.
$template = new TXTemplateHelper($this);

//make this position array to object.
$pos= $template->arrayToObject($position);

//calculate orginal layout grid
$layoutGrid= $template->setLayoutGrid();

//get custom background style
if($template->get('tempStyle')=='custom'){
    $style= $template->getCustomStyle();
    $background= $style->bg;
}

//frontend style changge. get style name and put it on session
if(isset($_REQUEST['tempStyle'])) $_SESSION['tempStyle'] = $_REQUEST['tempStyle'];

//Module overlay. if enable then direct user to main domain.
if(isset($_GET['tp'])==1){
    if($template->get('moduleOverlay')){
        header("Location: ". $template->baseUrl());
    }
}

//date formation and set date var
if($template->get('showDate')){
    switch($formate= $template->get('showDate-1-formate')){
        case '1':
            $date= JHTML::_('date', 'now', JText::_('TX_FORMAT_LC'));
            break;
        case '2':
            $date= JHTML::_('date', 'now', JText::_('TX_FORMAT_LC2'));
            break;
        case '3':
            $date= JHTML::_('date', 'now', JText::_('TX_FORMAT_LC3'));
            break;
        case '4':
            $date= JHTML::_('date', 'now', JText::_('TX_FORMAT_LC4'));
            break;
        
    }
}

//load on demand css file.
$template->loadCss();

//load Js on demand
$template->loadJs();

//create a var copyright if copyright is enable text
if($template->get('copyright')) $copyright= $template->get('copyright-1-copyrightText');
else $copyright= 'Copyright &copy; 2011-2012 All right reserved.';

//create a var logo 
if($template->get('logoType')=='text'){
    $logo=1;
    $logoText= $template->get('logoType-text-title');
    $logoSlogan= $template->get('logoType-text-slogan');
} 

//detarmine component will display on frontpage of not
if(!$template->get('displayComponent') && $template->isFrontPage()) $displayCom= 1;

//set login area
if($template->get('login')) $login=1;

//set analytics var
if($template->get('analytics')){
  $analytics=1;
  $analyticsID= $template->get('analytics-1-id');  
} 

