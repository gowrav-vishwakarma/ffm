<?php
class Model_KitTransfers extends Model_Table {
	var $table= "jos_xxkittransfers";
	function init(){
		parent::init();
		$this->hasOne('Kit','kit_id');
		$this->hasOne('LedgerAll','from_ledger_id');
		$this->hasOne('LedgerAll','to_ledger_id');
		$this->addField('no_of_kits');
		$this->addField('order_date')->defaultValue($this->api->recall('setdate',date('Y-m-d')));
		$this->addField('is_completed')->type('boolean')->defaultValue(false);
		$this->addField('Transfered')->defaultValue(0);
		$this->addField('Transfered_on')->defaultValue(null);
		$this->addField('Accepted_Received')->type('boolean')->defaultValue(false);
		$this->hasOne('Pos','pos_id');
	}
}