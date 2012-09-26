<?php

class Model_MyStocks extends Model_Stock {
	function init(){
		parent::init();
		$this->addCondition('pos_id',$this->api->auth->model['pos_id']);
		
	}
}