<?php
class page_vouchers_payment extends page_voucher {
	function init(){
		parent::init();
		$v=$this->add('View_PaymentVoucher');
	}
}