<?php

class View_DistributorSalesVoucher extends View_SalesPurchaseVoucher{

	protected $party_ledgers = array("Distributors");
	protected $sales_purchase_ledger = array("Sales Account");
	protected $voucher_model = "SalesVoucher";
	protected $has_details = 3;
	protected $rate_field = "DP";


	function init(){
		parent::init();

		$this->dr_details = array('party'=>'total_amount');
		$this->cr_details = array('account'=>'total_amount');

		if($this->form->isSubmitted()){
			$this->handleForm($this->form);
		}

	}

	function handleForm(&$form){

		parent::handleForm($form);

		$item_details=$this->item_details;
		$pv=0;
		$bv=0;
		$rp=0;

		$item_m=$this->add('Model_Item');

		foreach($item_details as $item){
			$pos=$this->add('Model_CurrentPOS');
			$pos->addStock($item['item_id'], -1 * $item['Qty']);
			$item_m->load($item['item_id']);
			// $pv += $item_m['PV'];
			$bv += $item_m['BV'];
			// $rp += $item_m['RP'];

		}

		// @TODO@ -- BV UPdate in Distributor panel
		$dist=$this->add('Model_Distributor');
		$dist->load($this->form->get(key(reset($this->dr_details)))); //party field from form
		
		
		$gen_slabs=$this->add('Model_GenerationSlabs');
		$gen_slabs->_dsql()->del('order')->order('name','asc');
		foreach($gen_slabs as $slb){
			$dist['ClosingBV']  = $dist['ClosingBV'] + $bv * $slb['name'] /100.0;
			// throw $this->exception($slb['name']);
			$dist->save();
			if($dist['sponsor_id']==0) break;
			$dist=$dist->ref('sponsor_id');	
		}


		$this->js(null, $form->js()->reload())->univ()->successMessage("Updating now items stock" .count($this->item_details))->execute();

		
	}
}