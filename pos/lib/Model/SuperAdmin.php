<?php
class Model_SuperAdmin extends Model_Staff {
	function init(){
		parent::init();
		$this->addCondition('pos_id',0);
	}
}