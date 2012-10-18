<?php
class page_vouchers_details extends Page {
	function init(){
		parent::init();
		$voucher_entry=$this->add('Model_VoucherEntry');
		$voucher_entry->load($_GET['voucher_id']);

		$voucher=$this->add('Model_VoucherAll');
		$voucher->addCondition('pos_id',$voucher_entry['pos_id']);
		$voucher->addCondition('VoucherType',$voucher_entry['VoucherType']);
		$voucher->addCondition('VoucherNo',$voucher_entry['VoucherNo']);
		$list=$this->add('CompleteLister',null,null,array('view/list/voucher'));
		$list->setModel($voucher);
		$list->template->trySet('created_at',date('d-M-Y',strtotime($voucher_entry['created_at'])));
	}

	
}