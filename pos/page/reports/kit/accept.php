<?php

class page_reports_kit_accept extends Page {
	function init(){
		parent::init();
		$grid=$this->add('Grid');
		$grid->setModel(
			$this->api->auth->model
				->ref('pos_id')
				->ref('ledger_id')
				->ref('MyKitsToTake')
				->addCondition('is_completed',true)
				->addCondition('Accepted_Received',false)
			);

		$grid->addColumn('Button','accept');
		if($_GET['accept']){
			$kit_transfer= $this->add('Model_KitTransfers');
			$kit_transfer->load($_GET['accept']);
			$kit_transfer['Accepted_Received']=true;
			$kit_transfer->save();

			$grid->js()->reload()->execute();
		}
	}
}