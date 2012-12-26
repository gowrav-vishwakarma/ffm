<?php

class View_GuestSalesVoucher extends View_SalesPurchaseVoucher{

	protected $party_ledgers = array("Cash Group","Bank Accounts");
	protected $sales_purchase_ledger = "Sales Account";
	protected $has_details = 3;
	protected $rate_field = "MRP";
	protected $voucher_model = "SalesVoucher";


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

		foreach($this->item_details as $item){
			$pos=$this->add('Model_CurrentPOS');
			$pos->addStock($item['item_id'], -1 * $item['Qty']);
		}

		// @TODO@ -- BV UPdate in Distributor panel

		$this->js()->univ()->successMessage("Updating now items stock" .count($this->item_details))->execute();

		
	}
}