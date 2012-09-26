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
?>


<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

 jimport('joomla.html.toolbar');

 class xDeveloperToolBars extends JObject
 {
        function getDefaultToolBar() {

              JToolBarHelper::title( 'xCIDeveloper projects', 'generic.png' );
              JToolBarHelper::preferences('com_xcideveloper', '500');
              JToolBarHelper::addNewX('component.addNew','New Component');
              JToolBarHelper::addNewX('module.addNew','New Module');
              JToolBarHelper::help('welcome.help');
        }

        function newProjectToolBar($prj){
              JToolBarHelper::title( "create new xCIDeveloper $prj", 'generic.png' );
              JToolBarHelper::cancel('welcome.index');
        }

 }

?>