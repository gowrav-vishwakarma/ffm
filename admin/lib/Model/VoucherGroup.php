<?php

class Model_VoucherGroup extends Model_MyVouchers {
	function init(){
		parent::init();
		$this->hasMany('VoucherEntry','VoucherNo','VoucherNo');
		$group=$this->join('jos_xxvouchers',$this->dsql()->expr('ov.VoucherNo = [this_voucher]')->setCustom('this_voucher',$this->getElement('VoucherNo')),null,'ov');
	}
}