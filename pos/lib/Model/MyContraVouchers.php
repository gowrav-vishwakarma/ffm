<?php
class Model_MyContraVouchers extends Model_Table {
	public $table="jos_xxvouchers";
	public $table_alias="cv";

	function init(){
		parent::init();

		$this->addExpression('ledger_contra_id',$this->dsql()->expr('cv.ledger_id'));

		$contra_rows=$this->join('jos_xxvouchers',$this->dsql()->expr('v2.VoucherNo=cv.VoucherNo and v2.id != cv.id and v2.VoucherType=cv.VoucherType'),null,'v2');

		$contra_rows->hasOne('MyLedgers','ledger_id');
        $contra_rows->hasOne('Pos','pos_id')->system(true);
        $contra_rows->hasMany('VoucherDetails','voucher_id');
        $contra_rows->addField('AmountCR');
        $contra_rows->addField('AmountDR');
        $contra_rows->addField('ContraAmount')->caption('Amount');
        $contra_rows->addField('VoucherNo')->system(true);
        $contra_rows->addField('Narration')->type('text');
        $contra_rows->addField('VoucherType')->enum('SALES','PURCHASE','JV','CONTRA')->mandatory("Voucher Type is must");
        $contra_rows->addField('RefAccount');
        $contra_rows->addField('has_details')->type('boolean')->system(true);

        $this->addCondition('pos_id',$this->api->auth->model['pos_id']);

	}
}