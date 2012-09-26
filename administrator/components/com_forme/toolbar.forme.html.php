<?php
/**
* @version 1.0.6
* @package RSform! 1.0.6
* @copyright (C) 2007 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');

class menuforme {


	function _DEFAULT()
	{
		JToolBarHelper::custom( 'main', 'preview.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}

	function INFO_MENU()
	{
		JToolBarHelper::back();
	}

	function EDIT_MENU()
	{
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		JToolBarHelper::custom( 'main', 'preview.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}

	function SETTINGS_MENU()
	{
		JToolBarHelper::save('saveset');
		JToolBarHelper::cancel('cancel');
		JToolBarHelper::custom( 'main', 'preview.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}

	function LISTFORMS_MENU()
	{
		JToolBarHelper::addNewX('newform');
		JToolBarHelper::custom( 'forms.copy', 'copy.png', 'copy_f2.png', _FORME_BACKEND_TOOLBAR_DUPLICATE, false );
		JToolBarHelper::deleteList( _FORME_BACKEND_TOOLBAR_REMOVE_MESSAGE, 'deleteform', _FORME_BACKEND_TOOLBAR_REMOVE );
		JToolBarHelper::publishList('publishform');
		JToolBarHelper::unpublishList('unpublishform');
		JToolBarHelper::custom( 'test', 'preview.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}

	function EDITFORM_MENU()
	{
		$cid 	= JRequest::getVar('cid', array());


		if($cid) JToolBarHelper::addNewX('newfield',_FORME_BACKEND_TOOLBAR_NEWFIELD);
		if($cid) JToolBarHelper::custom( 'fields.copy.screen', 'copy.png', 'copy_f2.png', _FORME_BACKEND_TOOLBAR_DUPLICATE, false );
		
		if($cid) JToolBarHelper::custom('false'."');javascript:window.open('" . JURI::root() . 'index.php?option=com_forme&fid=' . $cid."&Itemid=99999');return false;;void('",'copy.png','copy_f2.png',_FORME_BACKEND_TOOLBAR_PREVIEW,false);		
		if($cid) JToolBarHelper::deleteList( _FORME_BACKEND_TOOLBAR_REMOVE_MESSAGE, 'deletefield', _FORME_BACKEND_TOOLBAR_REMOVE );
		JToolBarHelper::save('saveform');
		JToolBarHelper::apply('applyform');
		JToolBarHelper::cancel('cancelform',_FORME_BACKEND_TOOLBAR_CLOSE);
		JToolBarHelper::custom( 'main', 'preview.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}
	
	function EDITFIELD_MENU()
	{
		JToolBarHelper::save('savefield');
		JToolBarHelper::apply('applyfield');
		JToolBarHelper::cancel('cancelfield',_FORME_BACKEND_TOOLBAR_CLOSE);
		JToolBarHelper::custom( 'main', 'preview.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}

	function LISTDATA_MENU()
	{
		JToolBarHelper::archiveList('exportdata',_FORME_BACKEND_TOOLBAR_EXPORT);
		JToolBarHelper::custom('exportalldata','archive.png','archive_f2.png',_FORME_BACKEND_TOOLBAR_EXPORT_ALL,false);
		JToolBarHelper::back('Back','index.php?option=com_forme&task=forms');
		JToolBarHelper::deleteList('','deldata');
		JToolBarHelper::custom( 'main', 'preview.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}
	
	function UPDATE()
	{
		JToolBarHelper::custom( 'main', 'preview.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}

	function FIELDS_COPY_SCREEN()
	{
		JToolBarHelper::custom( 'fields.copy', 'copy.png', 'copy_f2.png', _FORME_BACKEND_TOOLBAR_DUPLICATE, false );
		JToolBarHelper::cancel('fields.copy.cancel',_FORME_BACKEND_TOOLBAR_CLOSE);
		JToolBarHelper::custom( 'main', 'preview.png', '', _FORME_BACKEND_TOOLBAR_MAIN, false );
	}
}

?>