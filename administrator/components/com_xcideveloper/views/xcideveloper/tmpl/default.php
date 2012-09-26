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


<?php if(!$com_extplorer) :?>
<h1>FOR Editing and Developing your project you need the modified version of Extplorer to be installed, available at http://www.xavoc.com</h1>
<?php endif; ?>
<table width="100%" class="adminlist">
<thead>
        <tr>
            <th class="title" width="10">#</th>
            <th class="title">Extension</th>
            <th class="title">Type</th>
          <th colspan="3" class="title">Admin</th>
          <th colspan="3" class="title">Front End</th>
          <th class="title">Detech</th>
          <th class="title">Package</th>
            <th class="title">Published</th>
        </tr>
  </thead>
    <tbody>
        <?php
        jimport('joomla.html.html');
        $i = 0;
        foreach ($result as $row) :
            $id = JHTML::_('grid.id', ++$i, $row->id);
            $published = JHTML::_('grid.published', $row, $i);
        switch($row->extension_type){
			case "com":
				include(JPATH_COMPONENT_ADMINISTRATOR.DS."views".DS."xcideveloper".DS."tmpl".DS."component_row.php");
				break;
			case "mod":
				include(JPATH_COMPONENT_ADMINISTRATOR.DS."views".DS."xcideveloper".DS."tmpl".DS."module_row.php");
				break;
		}
                endforeach;
        ?>
  </tbody>
</table>
<blockquote>
  <p>Although you can use pure Code Igniter here but still there are a few (really very few) tweeks you must go through to take full advantage of this system. <a href="../index.php?option=com_xcideveloper" target="_blank">CLICK HERE</a> for a complete help or <a href="http://www.xavoc.com" target="_blank">CLICK HERE</a> to go to<a href="http://www.xavoc.com" target="_blank"> XAVOC.com</a> for latest updates.</p>
  <p>
  <div align="center"><iframe src="http://www.xavoc.com/index.php?option=com_xavocnews&format=raw" width="700" height="100">Latest Xavoc Information here</iframe></div>
  </p>
</blockquote>
