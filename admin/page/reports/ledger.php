<?php

class page_reports_ledger extends page_reports {
	function init(){
		parent::init();

		$form=$this->add('Form');
		$form->addField('ledger','ledger_id')->setModel($this->add('Model_MyLedgers'));
		$form->addSubmit("Show");

		$m= $this->add('Model_MyLedgers');
		
		if($_GET['ledger_id']){
			$grid=$this->add('Grid');
			$m->load($_GET['ledger_id']);
			$md=$m->ref('MyContraVouchers');
			// $md->debug();
			$grid->setModel($md,array('ledger_contra_id','ledger','pos','AmountCR','AmountDR','Narration','VoucherTpe'));
		}

		if($form->isSubmitted()){
			$this->js()->reload(array('ledger_id'=>$form->get('ledger_id')))->execute();
		}
	}
}