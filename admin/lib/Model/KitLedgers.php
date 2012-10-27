<?php
class Model_KitLedgers extends Model_Table {
	var $table= "jos_xxkitledgers";
	function init(){
		parent::init();
		$this->hasOne('Kit','kit_id');
		$this->hasOne('LedgerAll','ledger_id')->display(array('form'=>'ledger'));
		$this->addField('Amount');
	}
}