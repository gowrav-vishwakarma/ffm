<?php

class Model_CurrentDitributor extends Model_Distributor{
	function init(){
		parent::init();
		$this->load($this->api->auth->model->id);
	}
}