<?php
/**
 * @package     gantry
 * @subpackage  admin.elements
 * @version		3.1.6 December 30, 2010
 * @author		RocketTheme http://www.rockettheme.com
 * @copyright 	Copyright (C) 2007 - 2010 RocketTheme, LLC
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
defined('JPATH_BASE') or die();



/**
 * @package     gantry
 * @subpackage  admin.elements
 */
class JElementFinalize extends JElement {

    /**
     * @global gantry used to access the core Gantry class
     * @param  $name
     * @param  $value
     * @param  $node
     * @param  $control_name
     * @return void
     */
	function fetchElement($name, $value, &$node, $control_name)
	{
		global $gantry;

        if ($gantry->get('file-inline-js-enabled') && isset($gantry->document->_script)) {
            jimport('joomla.filesystem.file');
            $filename = JPATH_ADMINISTRATOR.DS.'tmp'.DS.'inline-javascript.js';

            JFile::write($filename, $gantry->document->_script);

            // add reference to static file
            $gantry->document->addScript('tmp/inline-javascript.js');

            // clear out the inline script from document;
            $gantry->document->_script = '';

        }

	}

}
