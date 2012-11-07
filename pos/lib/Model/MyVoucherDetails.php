<?php

class Model_MyVoucherDetails extends Model_VoucherDetails {
	function init(){
		parent::init();
		$this->addCondition('pos_id',$this->api->auth->model['pos_id']);
		
	}
}