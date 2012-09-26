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

class ZTLibrary
{
	function getUserIP()
	{
		if(isset($_SERVER)) {
			if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){return $_SERVER["HTTP_X_FORWARDED_FOR"];}
			if(isset($_SERVER["HTTP_CLIENT_IP"])){return $_SERVER["HTTP_CLIENT_IP"];}
			return $_SERVER["REMOTE_ADDR"];
		}
		
		if(getenv('HTTP_X_FORWARDED_FOR')){return getenv('HTTP_X_FORWARDED_FOR');}
		if(getenv('HTTP_CLIENT_IP')){return getenv('HTTP_CLIENT_IP');}
		
		return getenv('REMOTE_ADDR');
	}
}
?>