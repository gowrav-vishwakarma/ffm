<?php
class page_pins_availablepins extends Page {
	function init(){
		parent::init();
		$pin=$this->add('Model_Pin');
		$pin->addCondition('pos_id',$this->api->auth->model['pos_id']);
		$pin->addCondition('under_pos',true);

		$grid=$this->add('Grid');
		$grid->setModel($pin);

	}
}