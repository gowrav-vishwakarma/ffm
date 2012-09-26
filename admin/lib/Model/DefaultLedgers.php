<?php
class Model_DefaultLedgers extends Model_LedgerAll {
	function init(){
		parent::init();
		$this->addCondition("default_account",true);
	}
}