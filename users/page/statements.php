<?php
class page_statements extends Page {
	function init(){
		parent::init();

		$this->add('H2')->set("Your Payment Statements");

		$grid=$this->add('Grid');
		$grid->setModel(
			$this->api->auth->model->ref('Closing'),
			array('closing','LastClosingCarryAmount','BinaryIncome','FutureBinary','RMB', 'ClosingAmount','ClosingTDSAmount',
				'ClosingServiceCharge','ClosingUpgradeDeduction','OtherDeduction','FirstPayoutDeduction','ClosingAmountNet'
				)
			);

		$grid->dq->order('id','Desc');

		$grid->addPaginator(10);
		$grid->addQuickSearch(array('closing','ClosingAmountNet'));
	}
}