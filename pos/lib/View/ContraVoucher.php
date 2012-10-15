<?php

class View_ContraVoucher extends View_PaymentReceiptVoucher{

	protected $party_ledgers = array("Cash Group","Bank Accounts");
	protected $payment_receipt_ledger = array("Cash Group","Bank Accounts");
	protected $voucher_model = "PaymentVoucher";
	protected $has_details = false;
	// protected $rate_field = "DP";


	function init(){
		parent::init();

		$this->dr_details = array('party'=>'total_amount');
		$this->cr_details = array('account'=>'total_amount');

		if($this->form->isSubmitted()){
			$this->handleForm($this->form);
		}

	}

	function handleForm($form){

		parent::handleForm($form);

		// foreach($this->item_details as $item){
		// 	$pos=$this->add('Model_CurrentPOS');
		// 	$pos->addStock($item['item_id'], -1 * $item['Qty']);
		// }


		$this->js()->univ()->successMessage("Contra Entry " .count($this->item_details))->execute();

		
	}
}