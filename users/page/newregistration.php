<?php
class page_newregistration extends Page {
	function init(){
		parent::init();
	
		$form=$this->add('Form');
		$form->setModel('Distributor',array(
								'sponsor_id',
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


			// Sponsor checkings for already filled leg
			$sponsor=$this->add('Model_Distributor');
			$sponsor->load($form->get('sponsor_id'));

			$sponsor_leg=$sponsor->ref('Leg');
			$sponsor_leg->addCondition('Leg',$form->get('leg'));
			$sponsor_leg->tryLoadAny();

			if($sponsor_leg->loaded()) $form->displayError('leg','This leg is already filled, try another');

			// check pins
			$pin=$this->add('Model_Pin');
			$pin->tryLoad($form->get('new_id'));
			if(!$pin->loaded() OR $pin['Pin'] != strtolower($form->get('pin')) OR $pin['Used']==true OR $pin['published']==false)
				$form->displayError('pin','Pin Validation failed or This is a Used pin or Not Activated Pin');

			$this->api->auth->model['pos_id'] = $pin['pos_id'];

			$form->model->memorize('leg',$form->get('leg'));
			$form->model->memorize('new_entry',true);
			$form->model['id'] =  $form->get('new_id');
			$form->model['pin_id']=$form->get('new_id');
			try{
				$this->api->db->beginTransaction();
					$form->update();
			}catch(Exception $e){
				$this->api->db->rollback();
				throw $e;
				$form->js()->univ()->errorMessage($e->getMessage())->execute();
			}

			$this->api->db->commit();

			$form->js(null,$form->js()->reload())->univ()->successMessage('Member Registred SucessFully')->execute();

		}
	}
}