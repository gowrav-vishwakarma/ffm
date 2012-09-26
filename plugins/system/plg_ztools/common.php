<?php
/*
# ------------------------------------------------------------------------
# ZTTools plugin for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright(C) 2008-2011 www.zootemplate.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: ZooTemplate
# Websites: http://www.zootemplate.com
# ------------------------------------------------------------------------
*/

function ZTimport($object)
{
	$object  = str_replace( '.', DS, $object );
	$path = dirname(dirname(__FILE__)).DS.$object.'.php';
	if (file_exists ($path)) require_once ($path);
}
function ZT_import($object)
{
	$path = dirname(dirname(__FILE__)).DS.$object.'.php';
	if (file_exists ($path)) require_once ($path);
}