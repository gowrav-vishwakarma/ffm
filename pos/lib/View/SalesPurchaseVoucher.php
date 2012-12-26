<?php

class View_SalesPurchaseVoucher extends View_Voucher{
	
	protected $party_ledgers;
	protected $sales_purchase_ledger;
	protected $has_details;
	protected $rate_field;

	function init(){
		parent::init();

		$this->form->addField('ledger','party',"Party")->setGroup($this->party_ledgers)->setEmptyText("Select party")->validateNotNull();
		$this->form->addField('ledger','account')->setGroup($this->sales_purchase_ledger)->setNotNull("Select Account");
		$this->form->addSeparator('atk-row');

		$this->form->js()->_load('distributorsalesform');

		if($this->has_details){
			for($i=1; $i<= $this->has_details; $i++){
				$item_field = $this->form->addField('dropdown','item'.$i)->setEmptyText("Select Item");
				$item_field->template->trySet('row_class','span3');
				$item_field->setModel('Item');
				$qty_field=$this->form->addField('line','qty'.$i);
				$qty_field->template->trySet('row_class','span3');
				$rate = $this->form->addField('line','rate'.$i);
				$rate->disable();
				// $item_field->includeDictionary(array($this->rate_field));
				// $item_field->js(true)->univ()->bindFillInFields(array($this->rate_field => $rate));
				if($_GET['item'.$i]){
					$itm=$this->add('Model_Item');
					$itm->load($_GET['item'.$i]);
					$rate->set($itm[$this->rate_field]);
					$rate->js(true)->univ()->calculate_bill_amount($this->form,$this->has_details);
				}else{
					$rate->template->trySet('row_class','span3');
				}
				$item_field->js('change',$this->form->js()->atk4_form('reloadField','rate'.$i,array($this->api->url(),"item".$i=>$item_field->js()->val())));

				$this->form->addField('line','amount'.$i)->disable()->template->trySet('row_class','span3');
				$this->form->addSeparator('atk-row');
				
				$item_field->js('change')->univ()->calculate_bill_amount($this->form,$this->has_details);
				$rate->js('change')->univ()->calculate_bill_amount($this->form,$this->has_details);
				$qty_field->js('change')->univ()->calculate_bill_amount($this->form,$this->has_details);

			}
		}

		$this->form->addSeparator();
		$this->form->addField('line','total_amount');
		
		$btn=$this->form->addButton('Validate And Submit');
		$btn->js('click',
				array(
					$this->form->js()->univ()->validate_bill_figuers($this->form,$this->has_details),
					$this->form->js()->submit()
				)
			);
		// $this->form->addSubmit("Submit Form");




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
		if($this->has_details){
			$details=array();
			for($i=1; $i <= $this->has_details; $i++){
				if($this->form->get('item'.$i)){
					$item_m=$this->add('Model_Item')->load($this->form->get('item'.$i));
					$details[] = array(
										'item_id'=>$this->form->get('item'.$i),
										'Rate' => $item_m[$this->rate_field],
										'Qty' => $this->form->get('qty'.$i),
										'Amount' => $item_m[$this->rate_field] * $this->form->get('qty'.$i)
									);
					$item_m->unload()->destroy();
				}
			}
			$this->item_details=$details;
		}

        // throw $this->exception (print_r($details));

        $pv->addVoucher($dr_array,$cr_array,true,$details);
        

		// $this->form->js()->univ()->successMessage($this->form->get('total_amount'))->execute();
	}
}