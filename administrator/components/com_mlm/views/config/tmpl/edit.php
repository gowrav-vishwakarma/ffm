<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
JHTML::_('behavior.tooltip');
?>
<form action="index.php?option=com_mlm&task=config_cont.saveConfig" method="post" name="adminForm" id="adminForm">
   <?php echo $config->render();?>
    <input type="hidden" name="boxchecked" value="0">
    <input type="hidden" name="task" value="">
    <input type="hidden" name="config" value="<?php echo $configFile; ?>">
    <input type="hidden" name="hidemainmenu">
    <input type="hidden" name="option" value="<?php echo JRequest::getVar('option')?>">
</form> 