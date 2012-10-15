<?php
class page_reports_kit_pending extends Page {
	function init(){
		parent::init();
		$grid=$this->add('Grid');
		$grid->setModel(
			$this->api->auth->model
				->ref('pos_id')
				->ref('ledger_id')
				->ref('MyKitsToGive')
				->addCondition('is_completed',false)
			);
	}
}