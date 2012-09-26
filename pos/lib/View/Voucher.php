<?php

class View_Voucher extends View {
	
	protected $voucher_model;
	protected $form;
	protected $dr_details;
	protected $cr_details;
	protected $item_details=array();

	function init(){
		parent::init();		
		$this->form = $this->add('Form');

	}

	function handleForm($form){

	}
}