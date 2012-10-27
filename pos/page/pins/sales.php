<?php
class page_pins_sales extends Page {
	function init(){
		parent::init();

		$tabs=$this->add('Tabs');
		$Availablepins=$tabs->addTabURL('pins_availablepins','POS Available Pins');
		$dispintab=$tabs->addTabURL("pins_changestatus","Pin Status Change");
		$dispintab=$tabs->addTabURL("pins_distributorsales","Distributor Pin Sale");
		$dispintab=$tabs->addTabURL("pins_possales","POS Pin Sale");
		$dispintab=$tabs->addTabURL("pins_transfer","Depot Pin Transfer");

	}
}