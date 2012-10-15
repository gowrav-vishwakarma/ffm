<?php
class page_pin_dashboard extends Page{
	function init(){
		parent::init();

		$tab=$this->add('Tabs');
		$tab->addTabUrl('pin_changestatus','Menage Pin Status');
		$tab->addTabUrl('pin_search','Search');
		$tab->addTabUrl('pin_generate','Ganrate New Pins');
		// $tab->addTabUrl('pin_transfer','Pin Transfer');

	} 
}