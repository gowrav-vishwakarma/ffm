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


<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class sample extends CI_Model{
    function  __construct() {
        parent::__construct();
    }

    function getAll(){
        $result=array("Xavoc International","by","Gowrav Vishwakarma");
        return $result;
    }
}
?>
