<?php
/**
* @version 1.0.6
* @package RSform! 1.0.6
* @copyright (C) 2007 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/
defined('_JEXEC') or die('Restricted access');

require_once( JApplicationHelper::getPath( 'toolbar_html' ) );
switch ( $task ) {

		case "new":
		case "edit":
		case "editA":
		case "copy":
		menuforme::EDIT_MENU();
		break;

		case "update":
		menuforme::UPDATE();
		break;

		case "forms":
		menuforme::LISTFORMS_MENU();
		break;

		case "newform":
		case "editform":
		menuforme::EDITFORM_MENU();
		break;

		case "newfield":
		case "editfield":
		menuforme::EDITFIELD_MENU();
		break;

		case "settings":
    	menuforme::SETTINGS_MENU();
    	break;

    	case "listdata":
    	menuforme::LISTDATA_MENU();
    	break;

    	case "fields.copy.screen":
    		menuforme::FIELDS_COPY_SCREEN();
    	break;

		default:
		menuforme::_DEFAULT();
		break;

	}

?>