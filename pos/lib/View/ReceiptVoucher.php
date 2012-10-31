<?php

class View_ReceiptVoucher extends View_PaymentReceiptVoucher{

	protected $party_ledgers = array("Distributors","Sundry Creditors");
	protected $payment_receipt_ledger = array("Cash Group","Bank Accounts");
	protected $voucher_model = "PaymentReceivedVoucher";
	protected $has_details = false;
	// protected $rate_field = "DP";


	function init(){
		parent::init();

		$this->cr_details = array('account'=>'total_amount');
		$this->dr_details = array('party'=>'total_amount');

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


		$this->js()->univ()->successMessage(" Payment Received" .count($this->item_details))->execute();

		
	}
}