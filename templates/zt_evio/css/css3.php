<?php 
/*------------------------------------------------------------------------
* ZT Template 1.6
* ------------------------------------------------------------------------
* Copyright (c) 2008-2011 ZooTemplate. All Rights Reserved.
* @license - Copyrighted Commercial Software
* Author: ZooTemplate
* Websites:  http://www.zootemplate.com
-------------------------------------------------------------------------*/
header('Content-type: text/css; charset: UTF-8');
header('Cache-Control: must-revalidate');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
$url = $_REQUEST['url'];
?>

#menusys_mega .menusub_mega  {
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	-webkit-box-shadow: #666 0px 5px 8px;
	-moz-box-shadow: #666 0px  5px 8px;
	box-shadow: #666 0px  5px 8px;
	position: relative;
	behavior: url(<?php echo $url; ?>/css/css3.htc);
}
#menusys_moo li ul {
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	-webkit-box-shadow: #666 0px 5px 8px;
	-moz-box-shadow: #666 0px  5px 8px;
	box-shadow: #666 0px  5px 8px;
	
	behavior: url(<?php echo $url; ?>/css/css3.htc);
}
#menusys_mega .menusub_mega .mega-group{
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	position: relative;
	behavior: url(<?php echo $url; ?>/css/css3.htc);
}