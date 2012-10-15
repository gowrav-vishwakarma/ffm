<?php
class page_reports_mlm_total extends Page {
	function init(){
		parent::init();
		$dists=$this->add('Model_Distributor');
		$this->template->trySet('total_joinings',$dists->count()->do_getOne());

		$sales=0;
		foreach($k=$this->add('Model_Kit') as $junk){
			$sales=$sales + ($k['joined_dist'] * $k['MRP']);
		}
		$this->template->trySet('total_receivings',$sales);

		$closing=$this->add('Model_Closing');
		$this->template->trySet('total_payouts',$closing->dsql()->field('sum(ClosingAmount)')->do_getOne());
		$this->template->trySet('total_payouts_net',$closing->dsql()->field('sum(ClosingAmountNet)')->do_getOne());
		
		// $dists=$this->add('Model_Distributor');
		$this->template->trySet('total_payouts_carried',$dists->dsql()->field('sum(ClosingCarriedAmount)')->do_getOne());
		$this->template->trySet('total_payouts_tds',$closing->dsql()->field('sum(ClosingTDSAmount)')->do_getOne());
		$this->template->trySet('total_deduction_admin',$closing->dsql()->field('sum(ClosingServiceCharge)')->do_getOne());
		$this->template->trySet('total_deduction_upgrade',$closing->dsql()->field('sum(OtherDeductions)')->do_getOne());
		$this->template->trySet('total_deduction_firstpayout',$closing->dsql()->field('sum(FirstPayoutDeduction)')->do_getOne());


	}

	function defaultTemplate(){
		return array('view/reports/mlm/total');
	}
}