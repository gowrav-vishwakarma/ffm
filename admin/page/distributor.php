<?php
class page_distributor extends Page {
	function page_index(){

		if($_GET['edit_id']){
			$this->js()->univ()->dialogURL("Edit Distributor",$this->api->url("./edit",array("did"=>$_GET['edit_id'])),array("buttons"=>false))->execute();
		}

		if($_GET['payment_did']){
			$this->js()->univ()->dialogURL(
										"Distributors Payouts",
										$this->api->url("./payouts",array("did"=>$_GET['payment_did'])),
										array(
											"buttons"=>false,
											"width"=>'100%',
											)
										)->execute();
		}

		$d=$this->add('Model_Distributor');	
		$grid=$this->add('Grid');
		$grid->setModel($d,array('name','sponsor_id','kit','JoiningDate'));
		$grid->addPaginator();
		$grid->addQuickSearch(array('name'));

		$grid->addColumn('Button','edit_id','Edit');
		$grid->addColumn('Button','payment_did','Payments');

	}

	function page_edit(){
		$this->api->stickyGET('did');
		$m= $this->add('Model_Distributor');
		$m->load($_GET['did']);
		$m->getElement('Password')->display('line');
		$m->getElement('PinManagerPassword')->display('line');

		$form=$this->add('Form');
		$form->addClass('stacked atk-row');
		$form->template->trySet('fieldset','span4');
		$form->setModel($m,
			array('fullname','Father_HusbandName','Dob','Address','District','City','PanNo','State',
				'Gender','Country','Nominee','RelationWithNominee','MobileNo','Bank','IFSC','AccountNumber',
				'PinManagerPassword','Password'
				)
			);

		$form->add('Order')
			->move($form->addSeparator('span4'),'before','PanNo')
			->move($form->addSeparator('span4'),'before','Bank')
			->now();

		$form->addSubmit("Update");
		if($form->isSubmitted()){

			$form->update();
			$form->js()->univ()->closeDialog()->execute();
		}

	}

	function page_payouts(){
		$this->api->stickyGET('did');

		$m=$this->add('Model_Closing');
		$m->addCondition('distributor_id',$_GET['did']);
		$m->addCondition('ClosingAmount','>',0);

		$grid = $this->add('Grid');
		$grid->setModel($m,array('distributor','closing','LastClosingCarryAmount','IntroductionAmount','RMB','BinaryIncomeFromIntrosShare','BinaryIncome','FutureBinary',
			'RoyaltyIncome','SurveyIncome','ClosingAmount','ClosingTDSAmount','ClosingServiceCharge','OtherDeductions','ClosingUpgradationDeduction',
			'FirstPayoutDeduction','ClosingAmountNet'));


	}
}