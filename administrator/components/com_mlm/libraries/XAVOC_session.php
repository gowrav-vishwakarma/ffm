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
?><?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class XAVOC_Session {
var $_flash = array();

    // constructor
    function Session() {
        if (!isset($_SESSION)) {
		  session_start();
		}
//        $this->flashinit();
    }
    
    /* Save a session variable.
     * @paramstringName of variable to save
     * @parammixedValue to save
     * @paramstring  (optional) Namespace to use. Defaults to 'default'. 'flash' is reserved.
    */
    function set_userdata($var, $val, $namespace = 'default') {
        $session =& JFactory::getSession();
        $session->set($var, $val, $namespace);
    }
    
    /* Get the value of a session variabe
     * @paramstring  Name of variable to load. null loads all variables in namespace (associative array)
     * @paramstring(optional) Namespace to use, defaults to 'default'
    */
    function userdata($var = null, $namespace = 'default') {
        $session =& JFactory::getSession();
        return $session->get($var, null, $namespace);
    }
    
    /* Clears all variables in a namespace
     */
    function unset_userdata($var = null, $namespace = 'default') {
        $session =& JFactory::getSession();
        return $session->clear($var, $namespace);

    }
    
    
}
?>