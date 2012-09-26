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
?><?php xCILoadTemplate();?>
<form action="index.php" method="get" name="adminForm" id="adminForm">
    <input type="hidden" name="boxchecked" value="0">
    <input type="hidden" name="task">
    <input type="hidden" name="hidemainmenu">
    <input type="hidden" name="option" value="<?php echo JRequest::getVar('option')?>">
</form> 