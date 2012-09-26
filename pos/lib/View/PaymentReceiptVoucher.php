<?php

class View_PaymentReceiptVoucher extends View_Voucher{
	
	protected $party_ledgers;
	protected $payment_receipt_ledger;
	// protected $has_details;
	// protected $rate_field;

	function init(){
		parent::init();

		$this->form->addField('ledger','party',"Party")->setGroup($this->party_ledgers)->setEmptyText("Select party")->validateNotNull();
		$this->form->addField('ledger','account')->setGroup($this->payment_receipt_ledger);
		// $this->form->addSeparator();

		// if($this->has_details){
		// 	for($i=1; $i<= $this->has_details; $i++){
		// 		$item_field = $this->form->addField('dropdown','item'.$i)->setEmptyText("Select Item");
		// 		$item_field->setModel('Item');
		// 		$this->form->addField('line','qty'.$i);
		// 		$rate = $this->form->addField('line','rate'.$i);
				
		// 		$item_field->js(true)->univ()->bindFillInFields(array($this->rate_field=>$rate));

		// 		$this->form->addField('line','amount'.$i);
		// 	}
		// }

		$this->form->addSeparator();
		$this->form->addField('line','total_amount');
		$this->form->addSubmit("Submit Form");




	}

	function handleForm($form){
		parent::handleForm($form);
		
		$pv=$this->add('Model_' . $this->voucher_model);

		$dr_array=array();

		foreach($this->dr_details as $ledger_field => $money_field){
			$dr_array[$this->form->get($ledger_field)]  = array('Amount'=> $this->form->get($money_field));
		}

		foreach($this->cr_details as $ledger_field => $money_field){
			$cr_array[$this->form->get($ledger_field)]  = array('Amount'=> $this->form->get($money_field));
		}

		$details=false;
		// if($this->has_details){
		// 	$details=array();
		// 	for($i=1; $i <= $this->has_details; $i++){
		// 		if($this->form->get('item'.$i)){
		// 			$details[] = array(
		// 								'item_id'=>$this->form->get('item'.$i),
		// 								'Rate' => $this->form->get('rate'.$i),
		// 								'Qty' => $this->form->get('qty'.$i),
		// 								'Amount' => $this->form->get('amount'.$i)
		// 							);
		// 		}
		// 	}
		// 	$this->item_details=$details;
		// }

        // throw $this->exception (print_r($details));

        $pv->addVoucher($dr_array,$cr_array,true,$details);

		// $this->form->js()->univ()->successMessage($this->form->get('total_amount'))->execute();
	}
}