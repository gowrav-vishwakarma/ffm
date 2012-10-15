<?php
class page_kits_togive extends Page {
	function init(){
		parent::init();
		$grid=$this->add('Grid');
		
		$l=$this->add('Model_LedgerAll');
		$l->getDistributorLedger($this->api->auth->model->id);

		$k=$this->add('Model_KitTransfers');
		$k->addCondition('from_ledger_id',$l->id);
		$k->addCondition('is_completed',false);
		
		$grid->setModel($k);
	}
}