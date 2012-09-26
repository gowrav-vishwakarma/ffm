<?php
/**
* @version 1.0.6
* @package RSform! 1.0.6
* @copyright (C) 2007 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

class forme_config extends JTable{
	var $id = null;
	var $setting_name = null;
	var $setting_value = null;

	function __construct( &$database ) {
		parent::__construct( '#__forme_config', 'id', $database );
	}

}

class forme_forms extends JTable{
	var $id = null;
	var $name = null;
	var $title = null;
	var $formstyle = null;
	var $fieldstyle = null;
	var $thankyou = null;
	var $email = null;
	var $emailto = null;
	var $emailfrom = null;
	var $emailfromname = null;
	var $emailsubject = null;
	var $emailmode = null;
	var $return_url = null;
	var $published = null;
	var $checked_out = null;
	var $checked_out_time = null;
	var $lang = null;
	var $script_process = null;
	var $script_display = null;

	function __construct( &$database ) {
		parent::__construct( '#__forme_forms', 'id', $database );
	}

}

class forme_fields extends JTable{
	var $id = null;
	var $form_id = null;
	var $name = null;
	var $title = null;
	var $fieldstyle = null;
	var $description = null;
	var $inputtype = null;
	var $default_value = null;
	var $params = null;
	var $validation_rule = null;
	var $validation_message = null;
	var $ordering = null;
	var $published = null;
	var $checked_out = null;
	var $checked_out_time = null;

	function __construct( &$database ) {
		parent::__construct( '#__forme_fields', 'id', $database );
	}

}

class forme_data extends JTable{
	var $id = null;
	var $form_id = null;
	var $date_added = null;
	var $uip = null;
	var $uid = null;
	var $params = null;

	function __construct( &$database ) {
		parent::__construct( '#__forme_data', 'id', $database );
	}

}
?>