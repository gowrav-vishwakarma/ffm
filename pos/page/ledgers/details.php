<?php
class page_ledgers_details extends Page {
	function init(){
		parent::init();
		$this->api->stickyGET('lid');

		if($_GET['voucher_id']){
				$this->js()->univ()->dialogURL(
										"Voucher Details",
										$this->api->getDestinationURL('vouchers_details',array('voucher_id'=>$_GET['voucher_id'])),
										array('buttons'=>false)
										)->execute();
		}

		$from=$this->api->recall('from_date','1970-01-01');
		$to=$this->api->recall('to_date',date('Y-m-d'));

		$ledger_m=$this->add('Model_MyLedgers')->load($_GET['lid']);

		$op=$this->add('H3');
		$date_range_msg=" From " . (($_GET['from_date']=="" ? "Start" : $_GET['from_date'])) . " to " . (($_GET['to_date']=="" ? "Today" : $_GET['to_date'])) ;
		$opbalance=$ledger_m->getOpeningbalance($from_date,false);
		$op->setHTML('Ledger details for <u>' . $ledger_m->get('name') . "</u> " . $date_range_msg . "<br/>". "openning Balance " . $opbalance['Amount'] . " (". $opbalance['Side'] .")");


		$m=$ledger_m->ref('MyContraVouchers');
		// $this->add('Text')->set($m->_dsql()->render());
		$grid=$this->add('Grid');
		$grid->setModel($m,array('contra_ledger','Amount_Voucher', 'FullVoucherNo','created_at','Narration'));
		$grid->addPaginator();
		$grid->addColumn('Button','voucher_id','Voucher Details');

		$grid->addHook('formatRow',array($this,'formatGridRow'));

		$cl=$this->add('H3');
		$clbalance=$ledger_m->getOpeningbalance(($_GET['to_date'] == "" ? $this->api->recall('setdate',date('Y-m-d')) :$_GET['to_date']));
		$cl->set("Closing Balance " . $clbalance['Amount'] . " (". $clbalance['Side'] .")");
	}

	function formatGridRow($g){

	}
}