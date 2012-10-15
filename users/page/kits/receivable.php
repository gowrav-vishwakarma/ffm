<?php
class page_kits_receivable extends Page {
	function init(){
		parent::init();
		$grid=$this->add('Grid');
		
		$l=$this->add('Model_LedgerAll');
		$l->getDistributorLedger($this->api->auth->model->id);

		$k=$this->add('Model_KitTransfers');
		$k->addCondition('to_ledger_id',$l->id);
		$k->addCondition('is_completed',false);
		
		$grid->setModel($k);
	}
}