<?php

class View_Distributordetails extends View {

	public $id;

	function init(){
		parent::init();
	}

	function render(){
		
		$m=$this->add('Model_DistributorWithDetails');
		$m->load($this->id);
		$this->setModel($m);

		parent::render();
	}

	function setModel($model){
		$sponsor=$model->ref('sponsor_id')->get('name');
		$this->template->trySet('sponsor_name',$sponsor);

		$leg_left=$this->add("Model_Leg")->addCondition('distributor_id',$model->id)->addCondition('Leg','A')->tryLoadAny();
		$leg_right=$this->add("Model_Leg")->addCondition('distributor_id',$model->id)->addCondition('Leg','B')->tryLoadAny();
		if($leg_left->loaded()){
			$this->template->trySet('session_pv_a',$leg_left['SessionPV']);
			$this->template->trySet('session_upgrade_a',$leg_left['SessionRP']);
			$this->template->trySet('session_newjoinings_a',$leg_left['SessionGreenCount']);

			$this->template->trySet('week_pv_a',$leg_left['ClosingPV']);
			$this->template->trySet('week_upgrade_a',$leg_left['ClosingRP']);
			$this->template->trySet('week_newjoinings_a',$leg_left['ClosingGreenCount']);

			// $this->template->trySet('total_pv_a',$leg_left['TotalPV']);
			// $this->template->trySet('total_upgrade_a',$leg_left['TotalRP']);
			$this->template->trySet('total_newjoinings_a',$leg_left['TotalGreenCount']);
		}
		if($leg_right->loaded()){
			$this->template->trySet('session_pv_b',$leg_right['SessionPV']);
			$this->template->trySet('session_upgrade_b',$leg_right['SessionRP']);
			$this->template->trySet('session_newjoinings_b',$leg_right['SessionGreenCount']);

			$this->template->trySet('week_pv_b',$leg_right['ClosingPV']);
			$this->template->trySet('week_upgrade_b',$leg_right['ClosingRP']);
			$this->template->trySet('week_newjoinings_b',$leg_right['ClosingGreenCount']);

			// $this->template->trySet('total_pv_b',$leg_right['TotalPV']);
			// $this->template->trySet('total_upgrade_b',$leg_right['TotalRP']);
			$this->template->trySet('total_newjoinings_b',$leg_right['TotalGreenCount']);

		}

		$this->template->trySet('ClosingBV',$model['ClosingBV']);

		parent::setModel($model);
	}

	function defaultTemplate(){
		return array("view/distributordetails");
	}
}