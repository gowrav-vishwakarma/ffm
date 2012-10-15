<?php
class Model_MyKitTransfers extends Model_KitTransfers {
	function init(){
		parent::init();
		$this->addCondition('pos_id',$this->api->auth->model['pos_id']);
	}
}