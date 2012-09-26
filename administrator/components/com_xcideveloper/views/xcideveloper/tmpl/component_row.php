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
if(!is_dir(JPATH_ADMINISTRATOR.DS."components".DS."com_".$row->component) OR !is_dir(JPATH_SITE.DS."components".DS."com_".$row->component))
                $deleted=true;
            else
                $deleted=false;
?>

<tr class="row<?php echo $i % 2 ?>">
  <td><?php echo $row->id; ?></td>
  <td  <?php if($deleted) echo 'style="background-color:#ffaadd"'; ?>><?php echo $row->com_name; ?></td>
  <td  <?php if($deleted) echo 'style="background-color:#ffaadd"'; ?>><?php echo $row->extension_type; ?></td>
  <td width="15"><?php echo JHTML::_('link',"index.php?option=com_xcideveloper&task=component.developProject&xcidevelop_side=administrator&xprjid=$row->id","Develop") ; ?></td>
  <td width="15">tools</td>
  <td width="15"><?php echo JHTML::_('link',"index.php?option=com_$row->component","Test",array('target' => 'adminTest')) ; ?></td>
  <td width="15"><?php echo JHTML::_('link',"index.php?option=com_xcideveloper&task=component.developProject&xprjid=$row->id","Develop") ; ?></td>
  <td width="15">tools</td>
  <td width="15"><?php echo JHTML::_('link',"../index.php?option=com_$row->component","Test",array('target' => 'sideTest')) ; ?></td>
  <td align="center"><?php echo JHTML::_('link',"index.php?option=com_xcideveloper&task=component.removeProject&xprjid=$row->id","Remove") ; ?></td>
  <td align="center"><?php echo JHTML::_('link',"index.php?option=com_xcideveloper&task=component.generatePackage&xprjid=$row->id","Generate") ; ?></td>
  <td align="center"><?php echo $published ?></td>
</tr>
