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
		$list->template->trySet('voucher_type',$voucher_entry['VoucherType']);
		$list->template->trySet('voucher_number',$voucher_entry['VoucherNo']);
		$list->template->trySet('voucher_narration',$voucher_entry['Narration']);

		$edit_btn=$this->add('Button')->set('Edit');
		$edit_btn->js('click')->univ()->dialogURL("Edit",$this->api->getDestinationURL('vouchers_edit',array('voucher_id'=>$_GET['voucher_id'])),array("buttons"=>false));

		$delete_btn=$this->add('Button')->set('Delete');
		$delete_btn->js('click')->univ()->dialogURL("Delete",$this->api->url('vouchers_delete',array('voucher_id'=>$_GET['voucher_id'])),array("buttons"=>false));

	}

	
}