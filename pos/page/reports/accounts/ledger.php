<?php

class page_reports_accounts_ledger extends page_reports {
	function init(){
		parent::init();

		$form=$this->add('Form');
		$form->addClass('stacked atk-row');
		$form->template->trySet('fieldset','span12');
		$ledfield=$form->addField('ledger','ledger_id');
		$ledfield->setModel($this->add('Model_MyLedgers'));
		$ledfield->template->trySet('row_class','span3');
		$form->addField('DatePicker','from_date')->template->trySet('row_class','span3');
		$form->addField('DatePicker','to_date')->template->trySet('row_class','span3');
		$form->addSubmit("Show");

		$m= $this->add('Model_MyLedgers');
		$op=$this->add('H3');
		$grid=$this->add('Grid');
		$cl=$this->add('H3');
		
		if($_GET['ledger_id']){
			$this->api->stickyGET('ledger_id');
			$this->api->stickyGET('from_date');
			$this->api->stickyGET('to_date');

			$date_range_msg=" From " . (($_GET['from_date']=="" ? "Start" : $_GET['from_date'])) . " to " . (($_GET['to_date']=="" ? "Today" : $_GET['to_date'])) ;

			$m->load($_GET['ledger_id']);
			$opbalance=$m->getOpeningbalance($_GET['from_date'],false);
			$op->setHTML('Ledger details for <u>' . $m->get('name') . "</u> " . $date_range_msg . "<br/>". "openning Balance " . $opbalance['Amount'] . " (". $opbalance['Side'] .")");


			$clbalance=$m->getOpeningbalance(($_GET['to_date'] == "" ? $this->api->recall('setdate',date('Y-m-d')) :$_GET['to_date']));
			$cl->set("Closing Balance " . $clbalance['Amount'] . " (". $clbalance['Side'] .")");

			$md=$m->ref('MyContraVouchers');
			if($_GET['from_date'])
				$md->addCondition('created_at','>=',$_GET['from_date']);
			if($_GET['to_date'])
				$md->addCondition('created_at','<=',$_GET['to_date']);
			$md->_dsql()->order('cv.created_at desc');
			// $md->debug();
			$grid->setModel($md,array('contra_ledger','pos','Amount_Voucher','Side','Narration','created_at','FullVoucherNo'));
			$grid->addPaginator();
			$grid->addColumn('Button','voucher_id','Voucher Details');
			if($_GET['voucher_id']){
				$this->js()->univ()->dialogURL(
										"Voucher Details",
										$this->api->getDestinationURL('vouchers_details',array('voucher_id'=>$_GET['voucher_id'])),
										array('buttons'=>false)
										)->execute();
			}

		}else{
			// $m->addCondition('ledger_id',-1);
			$grid->setSource(array());
		}

		if($form->isSubmitted()){
			$this->js()->reload(array(
					'ledger_id'=>$form->get('ledger_id'),
					'from_date'=>$form->get('from_date'),
					'to_date'=>$form->get('to_date')
				))->execute();
		}
	}

/*	function formatRow(&$obj){
		throw $this->exception($obj);
		if(isset($obj->totals['CR']))
			$cr=$obj->totals['CR'];
		else{
			$cr=0;
			$obj->totals['CR']=0;
		}

		$obj->totals['CR'] = $cr + ($obj->current_row['Side'] == 'CR' ? $obj->current_row['Amount'] : 0);

		if(isset($obj->totals['DR']))
			$dr=$obj->totals['DR'];
		else{
			$dr=0;
			$obj->totals['DR']=0;
		}

		$obj->totals['DR'] = $dr + ($obj->current_row['Side'] == 'DR' ? $obj->current_row['Amount'] : 0);
	}*/

}