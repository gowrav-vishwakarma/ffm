<?php
/*------------------------------------------------------------------------
# com_xcideveloper - Seamless merging of CI Development Style with Joomla CMS
# ------------------------------------------------------------------------
# author    Xavoc International / Gowrav Vishwakarma
# copyright Copyright (C) 2011 xavoc.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.xavoc.com
# Technical Support:  Forum - http://xavoc.com/index.php?option=com_discussions&view=index&Itemid=157
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?><?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 function xCILoadTemplate($tpl=false,$parseConetentPrepare=true,$data=null){
     global $xCICurrentVIEW;
     if(!$tpl)
        $tpl=JRequest::getVar('layout','default');
     $ci=& get_instance();
     $ci->load->view($xCICurrentVIEW . "/tmpl/".$tpl,$data,false,$parseConetentPrepare);
 }

 function xRedirect($url,$msg=null,$msgType='message'){
      jimport('joomla.application.component.controller');
        $c=new JController();
        $c->setRedirect($url,$msg,$msgType);
        $c->redirect();
 }
?>
