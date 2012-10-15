<?php
class page_reports_pins_available extends Page {
	function init(){
		parent::init();
		$p=$this->add('Model_Pin');
		$p->addCondition('pos_id',$this->api->auth->model['pos_id']);
		$p->addCondition('under_pos',true);
		$p->addCondition('Used',false);

		$grid=$this->add("Grid");
		$grid->setModel($p);
	}
}