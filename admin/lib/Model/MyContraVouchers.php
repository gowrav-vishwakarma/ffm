<?php
/*
	cv is actually current row and v2 is opposite voucher entries
*/
class Model_MyContraVouchers extends Model_MyVouchers {
	public $table_alias="cv";
	function init(){
		parent::init();
		$this->addExpression('ledger_contra_id',$this->dsql()->expr('cv.ledger_id'));
		$contra=$this->join('jos_xxvouchers',$this->dsql()->expr('v2.VoucherNo=cv.VoucherNo and v2.entry_side != cv.entry_side and v2.pos_id=cv.pos_id and v2.VoucherType=cv.VoucherType'),null,'v2');

		$contra_ledger=$contra->join('jos_xxledgers',$this->dsql()->expr('v2.ledger_id=l2.id'),null,'l2');
		$contra_ledger->addField('contra_ledger','name');

		// Currently working Expression for Amount
		// $this->addExpression('Amount')->set('IF(v2.AmountDR is null, IF(v2.AmountCR is null, cv.AmountCR,v2.AmountCR), cv.AmountCR)');
		$this->addExpression('Amount')
		->set('IF(v2.AmountDR is null, 
					IF(v2.AmountCR is null, 
						cv.AmountCR,
						v2.AmountCR), 
					cv.AmountCR)');
		$this->addExpression('Side')->set('v2.entry_side');
		$this->addExpression('FullVoucherNo')->set('concat(v2.VoucherType,"-",v2.VoucherNo)');
	}
}