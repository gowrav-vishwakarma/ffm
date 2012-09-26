<?php

class page_rewards extends Page {
	function init(){
		parent::init();

		$this->add('H2')->set("Your Millionier Rewards");

		$millionrewards=$this->api->auth->model->ref('MillionRewards');
		
		$grid=$this->add("Grid");
		$grid->setModel($millionrewards,array('PV_1000_Reward','PV_35000_Reward','PV_85000_Reward','PV_335000_Reward'));

		$this->add('H2')->set("Your Billionier Rewards");
		$billionrewards=$this->api->auth->model->ref('BillionRewards');
		
		$grid=$this->add("Grid");
		$grid->setModel($billionrewards,array('Pair_10','Pair_25','Pair_50','Pair_100','Pair_300','Pair_4000','Pair_10000','Pair_20000'));
	}
}