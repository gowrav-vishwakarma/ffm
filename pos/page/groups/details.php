<?php
class page_groups_details extends Page {
	function init(){
		parent::init();
		$this->api->stickyGET('group_id');
		$group=$this->add('Model_MyGroups');
		$group->tryLoad($_GET['group_id']);

		if(!$group->loaded())
			$this->api->redirect('/');

		$this->add('H3')->set('Voucher Details for ' . $group['name'] . " from " . $this->api->recall('from_date') . " to " . $this->api->recall('to_date'));

		$voucher=$this->add('Model_MyContraVouchers');
		$led=$voucher->join('jos_xxledgers','ledger_id');
		$led->addField('group_id');

		$voucher->addCondition('group_id',$group->id);
		$voucher->addCondition('created_at','>=',$this->api->recall('from_date'));
		$voucher->addCondition('created_at','<=',$this->api->recall('to_date'));
		$voucher->_dsql()->order('created_at, cv.id');

		$grid=$this->add('Grid');
		$grid->setModel($voucher,array('ledger_contra_id','contra_ledger','Amount','Side','FullVoucherNo','created_at','Narration'));
		$grid->addPaginator();
		$grid->addColumn('Button','voucher_id','Voucher Details');
		if($_GET['voucher_id']){
				$this->js()->univ()->dialogURL(
										"Voucher Details",
										$this->api->getDestinationURL('vouchers_details',array('voucher_id'=>$_GET['voucher_id'])),
										array('buttons'=>false)
										)->execute();
			}
	}
}