<?php
class page_profile extends Page {
	function init(){
		parent::init();
		$form= $this->add('Form');
		$m=$this->add("Model_Distributor");
		$m->load($this->api->auth->model->id);
		$form->setModel($m,array('Father_HusbandName','Gender','Dob','PanNo',
											'Address','City','State','Country','MobileNo',
											'Nominee','RelationwithNominee','NomineeDob',
											'Bank','IFSC','AccountNumber','Password'));
		$form->addField('password','repassword','Re Type Password');
		$form->addSubmit("Update");


		if($form->isSubmitted()){
			if($form->get('Password')!=$form->get('repassword'))
				$form->displayError("repassword","Password must Match");
			
			$form->update();

			$form->js(null,array(
					$form->js()->univ()->successMessage("Information Updated"),
					$form->js()->reload()
				))->execute();
		}

	}
}