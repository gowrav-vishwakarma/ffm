<?php
/**
 * @copyright	Copyright(C) 2008 - 2011 ZooTemplate.com. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
include_once(dirname(__FILE__).DS.'libs'.DS.'browser.php');
include_once(dirname(__FILE__).DS.'libs'.DS.'zt_tools.php');
include_once(dirname(__FILE__).DS.'zt_menus'.DS.'zt.common.php');
include_once(dirname(__FILE__).DS.'libs'.DS.'zt_vars.php');

unset($this->_scripts[$this->baseurl.'/media/system/js/caption.js']);

if($myBrowser) {
	include_once(dirname(__FILE__).DS.'_mobile.php');
} else {
	include_once(dirname(__FILE__).DS.'_default.php');
}
?>