<?php

class Model_CurrentDistributor extends Model_Distributor{
	function init(){
		parent::init();
		$this->load($this->api->auth->model->id);
	}
}