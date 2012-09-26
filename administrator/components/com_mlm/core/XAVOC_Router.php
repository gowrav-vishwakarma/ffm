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
?><?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Router
 *
 * @author Xavoc
 */
class XAVOC_Router extends CI_Router{
    function _set_routing(){
		global $xCICurrentExtension;
                global $xIMModule;
        @include(constant($xCICurrentExtension.'APPPATH').'config/routes'.EXT);
        $this->routes = ( ! isset($route) OR ! is_array($route)) ? array() : $route;
        unset($route);

        if ($this->config->item('enable_query_strings') === TRUE AND !isset($_GET[$this->config->item('controller_trigger')]) OR $xIMModule == true ){
            $_GET[$this->config->item('controller_trigger')] = $this->routes['default_controller'];
        }

        if(isset($_GET['task']) AND $xIMModule != true){
            $taskparts=explode(".", $_GET['task']);
            if(count($taskparts)== 2){
                $_GET[$this->config->item('controller_trigger')]=$taskparts[0];
                $_GET[$this->config->item('function_trigger')]=$taskparts[1];
            }
        }
        parent::_set_routing();
        unset($_GET[$this->config->item('controller_trigger')]);
    }
}