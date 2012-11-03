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

		// $current_ledger=$this->join('jos_xxledgers',$this->dsql()->expr('cv.ledger_id=cl.id'),null,'cl');

		$contra_ledger=$contra->join('jos_xxledgers',$this->dsql()->expr('v2.ledger_id=l2.id'),null,'l2');
		$contra_ledger->addField('contra_ledger','name');
		// Currently working Expression for Amount
		// $this->addExpression('Amount')->set('IF(v2.AmountDR is null, IF(v2.AmountCR is null, cv.AmountCR,v2.AmountCR), cv.AmountCR)');
		$this->addExpression('Side')->set('cv.entry_side');
		$this->addExpression('Amount_Voucher')
		->set('Concat(
				IF(cv.entry_count_in_side <> 1,if(cv.AmountDR=0,cv.AmountCR,cv.AmountDR),if(v2.AmountDR=0,v2.AmountCR,v2.AmountDR)) 
				, " ", cv.entry_side)
				');
		// $this->addExpression('Amount')
		// ->set('IF(cv.entry_count_in_side = 1, 
		// 			IF(v2.AmountCR = 0, 
		// 				v2.AmountDR,
		// 				v2.AmountCR), 
		// 			IF(cv.AmountCR = 0, 
		// 				cv.AmountDR,
		// 				cv.AmountCR)
		// 		)');

		// $this->addExpression('contra_ledger')
		// ->set('IF(cv.entry_count_in_side = 1, 
		// 			l2.name, 
		// 			l2.name
		// 		)');


		$this->addExpression('FullVoucherNo')->set('concat(v2.VoucherType,"-",v2.VoucherNo)');
	}
}