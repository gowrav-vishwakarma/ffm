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

		$this->form->addField('Radio','payment')->setValueList(array('done'=>'Paid','due'=>'Payement Due'))->setNotNull();
		$this->form->addField('ledger','pay_led','Payment Ledger')->setGroup(array("Cash Group","Bank Accounts"))->setEmptyText("Select Payment mode");                

		if($this->form->isSubmitted()){
			$this->handleForm($this->form);
		}

	}

	function handleForm(&$form){
		
		if($this->form->get('payment')=='done' and $this->form->get('pay_led')==null){
			$this->form->displayError('pay_led_2','Its a must field for paid invoice');
		}

		parent::handleForm($form);
		
		if($this->form->get('payment') == 'done'){
        	// Entry for Payment voucher also done at this time
        	$vou=$this->add('Model_PaymentReceivedVoucher');
        	$dr_array=array();
        	$cr_array=array();

        	$dr_array[$this->form->get('pay_led')] = array('Amount'=>$this->form->get('total_amount'));
        	$cr_array[$this->form->get('party')] = array('Amount'=>$this->form->get('total_amount'));
        	$vou->addVoucher($dr_array,$cr_array,true);
        }


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
			$bv += ($item_m['BV'] * $item['Qty']);
			// $rp += $item_m['RP'];

		}

		// @TODO@ -- BV UPdate in Distributor panel
		$dist_ledger=$this->add('Model_Ledger')->load($this->form->get('party')); // ref line no 15
		$dist=$dist_ledger->ref('distributor_id');
		// throw $form->exception($form->get(key(reset($this->dr_details))));
		
		$gen_slabs=$this->add('Model_GenerationSlabs');
		$gen_slabs->_dsql()->del('order')->order('name','asc');

		$arr=array();
		
		foreach($gen_slabs as $slb){
			$dist['ClosingBV']  = $dist['ClosingBV'] + $bv * $slb['name'] /100.0;
			$dist->save();
			$arr[] = array('distributor'=>$dist->id,'ClosingBV'=>$dist['ClosingBV'],'SlabPer'=>$slb['name'], 'BV'=>$bv, 'Saved BV'=>$dist['ClosingBV'] + $bv * $slb['name'] /100.0);
			if($dist['sponsor_id']==0) break;
			$dist=$dist->ref('sponsor_id');	
		}
		// throw $this->exception(print_r($arr));


		$this->js(null, $form->js()->reload())->univ()->successMessage("Updating now items stock" .count($this->item_details))->execute();

		
	}
}