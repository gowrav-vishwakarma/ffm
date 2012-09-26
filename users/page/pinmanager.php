<?php
class page_pinmanager extends Page {
	function init(){
		parent::init();

		$tabs=$this->add('Tabs');

		$available_pins_tab=$tabs->addTabURL('availablepins',"My Available Pins");
		$available_pins_tab=$tabs->addTabURL('usedpins',"My Used Pins");

		$pinpasswordtab=$tabs->addTab("Manage Pin Password");
		


	}
}