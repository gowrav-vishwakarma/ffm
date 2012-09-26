<?php
class page_vouchers_receive extends page_voucher {
	function init(){
		parent::init();
		$v=$this->add('View_ReceiptVoucher');
	}
}