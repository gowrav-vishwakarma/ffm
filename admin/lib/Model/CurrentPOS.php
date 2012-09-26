<?php

class Model_CurrentPOS extends Model_Pos {
	function init(){
		parent::init();
		$this->addCondition('id',$this->api->auth->model['pos_id']);
		$this->tryLoadAny();
	}
}