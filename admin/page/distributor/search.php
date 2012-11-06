<?php
class page_distributor_search extends Page {
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
                $form=$this->add('Form');
                $form->addField('autocomplete/basic','distributor_id')->mustMatch()->setModel($d);
                $form->addField('autocomplete/basic','kit')->mustMatch()->setModel("Kit");
                $form->addField('line','Name');
//                $form->addField('autocomplete/basic','adcrd_id')->mustMatch()->setModel($d);
                $form->addField('autocomplete/basic','Under_id')->mustMatch()->setModel($d);
                $form->addField('line','Address');
                $form->addField('line','Pan_no');
                $form->addField('line','Mobile_no');
                $form->addField('DatePicker','joining_date');
                $form->addSubmit('Search');

		$d=$this->add('Model_Distributor');	
                
                if($_GET['filter']){
                    if($_GET['distributor_id']) $d->addCondition('id',$_GET['distributor_id']);
                    
                    if($_GET['Name']) $d->addCondition("name",'like', '%'.$_GET['Name'].'%');
                    
//                    if($_GET['adcrd']) $d->addCondition('adcrd_id',$_GET['adcrd']);
                    
                    if($_GET['kit']) $d->addCondition('kit_id',$_GET['kit']);
                    
                    if($_GET['Address']) $d->addCondition('Address','like','%'. $_GET['Address'].'%');
                    
                    if($_GET['Pan_no']) $d->addCondition('PanNo','like','%'.$_GET['Pan_no'].'%');
                    
                    if($_GET['Mobile_no']) $d->addCondition('MobileNo','like','%'.$_GET['Mobile_no'].'%');
                    
                    if($_GET['joining_date']) $d->addCondition('JoiningDate','>=', $_GET['joining_date']);
                   
//                    $d->debug();
                }
                
		$grid=$this->add('Grid');
		$grid->setModel($d,array('name','sponsor_id','kit','JoiningDate','Address','MobileNo','PanNo'));
		$grid->addPaginator();
		$grid->addQuickSearch(array('name'));

		$grid->addColumn('Button','edit_id','Edit');
		$grid->addColumn('Button','payment_did','Payments');
                
                if($form->isSubmitted()){
                    
                    $grid->js()->reload(array("distributor_id"=>$form->get("distributor_id"),
                                                "kit"=>$form->get("kit"),
                                                  "Name"=>$form->get("Name"),    
                                                    "Under_id"=>$form->get("Under_id"),
                                                    "Address"=>$form->get("Address"),
                                                    "Pan_no"=>$form->get("Pan_no"),
                                                    "Mobile_no"=>$form->get("Mobile_no"),
                                                    "joining_date"=>$form->get("joining_date"),
                                                    "filter"=>1
                                                ))->execute();
                }

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