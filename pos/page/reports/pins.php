<?php
class page_reports_pins extends page_reports {
	function init(){
		parent::init();
		$tabs=$this->add('Tabs');
		$tabs->addTabURL('reports_pins_available','Direct Available Pins');
		$tabs->addTabURL('reports_pins_used','Direct Used Pins');
	}
}