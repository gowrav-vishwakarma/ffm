<?php
/**
* @version 1.0.6
* @package RSform! 1.0.6
* @copyright (C) 2007 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/
defined('_JEXEC') or die('Restricted access');
function com_install() {
	$database =& JFactory::getDBO();
  ?>
  <center>
  <table width="100%" border="0">
   <tr>
      <td>
        <strong>RSform!</strong><br/>
        Released under the terms and conditions of the License</a>.<br>
		<br/>
      </td>
    </tr>
    <tr>
      <td background="E0E0E0" style="border:1px solid #999;" colspan="2">
        <code>Installation Process:<br />
        <?php
			$database->setQuery("ALTER TABLE `#__forme_fields` CHANGE `ordering` `ordering` INT( 11 ) NOT NULL DEFAULT '0'");
			$database->query();
          # Set up new icons for admin menu
          $database->setQuery("UPDATE #__components SET admin_menu_img='../administrator/components/com_forme/images/logo.gif' WHERE admin_menu_link='option=com_forme'");
          $iconresult[0] = $database->query();
            if ($iconresult[0]) {
              echo "<font color='green'>FINISHED:</font> Image of menu entry has been corrected.<br />";
            } else {
              echo "<font color='red'>ERROR:</font> Image of menu entry $i could not be corrected.<br />";
            }

		$upload_folder = JPATH_SITE."/components/com_forme/uploads/";
		$makedir = @mkdir($upload_folder);
         if (is_writable($upload_folder)) {
			echo "<font color='green'>FINISHED:</font> Directory $upload_folder created. Write permissions are set<br />";
		 } else {
		 	echo "<font color='red'><strong>Attention: Please set permissions to writable to $upload_folder</strong></font><br />";
		 }
        ?>
		<br><br>
   		<font color="green"><b>Joomla! RSform! 1.0.6 Installed Successfully!</b></font><br />
		Please make sure that RSform! has write access in the above shown directories! Have fun.<br />
		</code>
      </td>
    </tr>
  </table>
  <p style="text-align:left;">
  	<img src="components/com_forme/images/rsform.gif"/><br/><br/>
		<b>RSform! Component for Joomla! 1.5 CMS</b><br/>
&copy; 2007 by <a href="http://www.rsjoomla.com" target="_blank">http://www.rsjoomla.com</a><br/>
All rights reserved.
<br/><br/>
This Joomla! Component has been released under a <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">GPL License</a>.<br/>
<em>Note: This package works only on Joomla! 1.5</em>
<br/><br/>
<b>Load Sample Data</b><br/>
If you don't know how to start, be sure to check out the "Add Sample Data" menu option or <a href="index.php?option=com_forme&task=sample">click here</a>
<br/><br/>
Thank you for using RSform!
<br/><br/>
The rsjoomla.com team.
<br/><br/>
<a href="index.php?option=com_forme"><big><strong>Continue</strong></big></a>
</p>
  </center>
  <?php
}
?>