<?php
class page_newregistration extends Page {
	function init(){
		parent::init();
	
		$form=$this->add('Form');
		$form->setModel('Distributor',array(
								'sponsor_id',
								'pin',
								'fullname',
							'Father_HusbandName',
							'Dob',
							'Password',
							'Retype_password',
							'MobileNo',
							'Address',
							'City',
							'State',
							'PinCode',
							'Nominee',
							'RelationWithNominee',
							'PanNo',
							'Bank',
							'IFSC',
							'AccountNumber'));
		$form->addField('dropdown','leg')->setValueList(array(
												"-1"=>"select leg",
												"A"=>"A",
												"B"=>"B"))->set('-1');
		$form->add('Order')->move('leg','after','sponsor')->now();
		$form->addField('line','new_id','Distributor ID');
		$form->addField('line','pin');
		$form->addSubmit('Submit');

		if($form->isSubmitted()){

			// Check for new joining stopped or not
			$admin=$this->add('Model_Admin');
			if($admin->getValue('NewJoinings') != 'Start')
				$form->js()->univ()->errorMessage("New Joining is stopped by Administrator")->execute();

			if($form->get('leg')=='-1') $form->displayError('leg','Please select any valid leg');


			// Sponsor checkings
			$sponsor=$this->add('Model_Distributor');
			$sponsor->load($form->get('sponsor_id'));

			$sponsor_leg=$sponsor->ref('Leg');
			$sponsor_leg->addCondition('Leg',$form->get('leg'));
			$sponsor_leg->tryLoadAny();

			if($sponsor_leg->loaded()) $form->displayError('leg','This leg is already filled, try another');

			// check pins
			$pin=$this->add('Model_Pin');
			$pin->tryLoad($form->get('new_id'));
			if(!$pin->loaded() OR $pin['Pin'] != strtolower($form->get('pin')) OR $pin['Used']==true)
				$form->displayError('pin','Pin Validation failed or This is a Used pin');



			$form->js()->univ()->successMessage('Got it till last')->execute();

		}
	}
}