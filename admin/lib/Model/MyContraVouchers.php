<?php
class Model_MyContraVouchers extends Model_MyVouchers {
	public $table_alias="cv";
	function init(){
		parent::init();
		$this->addExpression('ledger_contra_id',$this->dsql()->expr('cv.ledger_id'));
		$this->join('jos_xxvouchers',$this->dsql()->expr('v2.VoucherNo=cv.VoucherNo and v2.id != cv.id'),null,'v2');
	}
}