<?php

class Model_MillionRewards extends Model_Table {
	var $table= "jos_xspecialreward";
	function init(){
		parent::init();
		$this->hasOne('Distributor','distributor_id');
		$this->addField('reward1')->defaultValue('0000-00-00 00:00:00');
		$this->addField('reward2')->defaultValue('0000-00-00 00:00:00');
		$this->addField('reward3')->defaultValue('0000-00-00 00:00:00');
		$this->addField('reward4')->defaultValue('0000-00-00 00:00:00');

		$joinintDate=$this->api->auth->model['JoiningDate'];

		$this->addExpression('PV_1000_Reward')->set(	
			'IF (
				reward1="0000-00-00 00:00:00",
					DATE_ADD("'.$joinintDate.'",INTERVAL 30 DAY),
					IF (
						reward1="1970-01-01 00:00:00",
							"Collapsed",
							concat("Achived On ",reward1)
						)
				)'
			);

		$this->addExpression('PV_35000_Reward')->set(
			'IF (
				reward2="0000-00-00 00:00:00",
					DATE_ADD("'.$joinintDate.'",INTERVAL 60 DAY),
					IF (
						reward2="1970-01-01 00:00:00",
							"Collapsed",
							concat("Achived On ",reward2)
						)
				)'
			);

		$this->addExpression('PV_85000_Reward')->set(
			'IF (
				reward3="0000-00-00 00:00:00",
					DATE_ADD("'.$joinintDate.'",INTERVAL 90 DAY),
					IF (
						reward3="1970-01-01 00:00:00",
							"Collapsed",
							concat("Achived On ",reward3)
						)
				)'
			);

		$this->addExpression('PV_335000_Reward')->set(
			'IF (
				reward4="0000-00-00 00:00:00",
					DATE_ADD("'.$joinintDate.'",INTERVAL 150 DAY),
					IF (
						reward4="1970-01-01 00:00:00",
							"Collapsed",
							concat("Achived On ",reward4)
						)
				)'
			);

		$this->addHook('beforeSave',$this);

	}

	function beforeSave(){
		// throw $this->exception('I m evil all in here');
		
		
	}

}