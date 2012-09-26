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

/**
 * Description of com_param
 *
 * @author Xavoc
 */
class com_params {
    var $params;
    var $menuParams;
    function  __construct() {
        $component = JComponentHelper::getComponent(trim(JRequest::getVar('option')));
        $this->params = new JParameter( $component->params );
        $this->menuParams = $this->params;
        $menuitemid = JRequest::getInt( 'Itemid' );
          if ($menuitemid)
          {
            $menu = JSite::getMenu();
            $menuparams = $menu->getParams( $menuitemid );
            $this->menuParams->merge( $menuparams );
          }
        
    }

    function getGlobalParam($key){
        return $this->params->get($key);
    }

    function getMenuParam($key){
        return $this->menuParams->get($key);
    }
}
?>
