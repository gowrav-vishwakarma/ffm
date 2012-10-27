<?php

class View_PurchaseVoucher extends View_SalesPurchaseVoucher{

	protected $party_ledgers = array('Sundry Creditors','Sundry Debtors','Bank Accounts','Cash Group');
	protected $sales_purchase_ledger = "Purchase Account";
	protected $has_details = 3;
	protected $rate_field = "MRP";
	protected $voucher_model = "PurchaseVoucher";


	function init(){
		parent::init();

		$this->cr_details = array('party'=>'total_amount');
		$this->dr_details = array('account'=>'total_amount');

		if($this->form->isSubmitted()){
			$this->handleForm($this->form);
		}

	}

	function handleForm($form){
		parent::handleForm($form);

		foreach($this->item_details as $item){
			$pos=$this->add('Model_CurrentPOS');
			$pos->addStock($item['item_id'],$item['Qty']);
		}

		$form->js(null,$form->js()->reload())->univ()->successMessage("Updating now items stock" .count($this->item_details))->execute();
		
	}

}