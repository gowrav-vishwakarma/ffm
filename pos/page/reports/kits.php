<?php
class page_reports_kits extends page_reports {
	function init(){
		parent::init();
		$tabs=$this->add('Tabs');
		$tabs->addTabURL('reports_kit_pending','Pending Kit Report');
		$tabs->addTabURL('reports_kit_receivable','Receivable Kit Report');
		$tabs->addTabURL('reports_kit_accept','Accept Received Kits');
	}
}