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
?>
<table width="100%" border="0" cellpadding="3" class="adminlist">
  <tr>
    <th>It is a Module for use on Frontend site</th>
    <td><label>
      <input name="ModuleSide" type="radio" id="modeSide" value="site" checked="checked" />
    </label></td>
  </tr>
  <tr>
    <th>It is a module for backend administrator</th>
    <td><input type="radio" name="ModuleSide" id="modeSide2" value="admin" disabled="disabled" /></td>
  </tr>
</table>
