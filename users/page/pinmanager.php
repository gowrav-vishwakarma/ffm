<?php
class page_pinmanager extends Page {
	function init(){
		parent::init();

		$tabs=$this->add('Tabs');

		$available_pins_tab=$tabs->addTabURL('availablepins',"My Available Pins");
		$available_pins_tab=$tabs->addTabURL('usedpins',"My Used Pins");
		$available_pins_tab=$tabs->addTabURL('kits_receivable',"My Kits Receivables");
		$available_pins_tab=$tabs->addTabURL('kits_togive',"My Kits Liability");
		$cd=$this->add('Model_CurrentDistributor');

		$pinpasswordtab=$tabs->addTab("Manage Pin Password");
		if($this->api->auth->model['PinManagerPassword']==null OR $this->api->auth->model['PinManagerPassword']==''){
			$view=$pinpasswordtab->add('View')->set('You Do not have any Pin Password yet, generate one now');
			
			$form=$pinpasswordtab->add('Form');
			$form->addSubmit("Generate New Pin Manager Password");
			$btn=$form->add('Button')->set('Logout and Use new Pin Manager Password');
			$btn->js('click',$this->js()->univ()->redirect('logout'));
			
			if($_GET['new_pass']){
				$view->set('Your New Pin Manager Password is '. $_GET['new_pass']);
			}
			
			if($form->isSubmitted()){
				$cd['PinManagerPassword']=rand(10000,99999);
				$cd->save();
				$this->api->auth->model['PinManagerPassword']=$cd['PinManagerPassword'];
				$view->js()->reload(array('new_pass'=>$cd['PinManagerPassword']))->execute();
			}
		}else{
			/*password change form*/
			$pc_form=$pinpasswordtab->add('Form');
			$pc_form->addField('password','old_pass');
			$pc_form->addField('password','new_password');
			$pc_form->addField('password','re_type');
			$pc_form->addSubmit("Change Password and Logout");
			if($pc_form->isSubmitted()){
				if($pc_form->get('new_password') != $pc_form->get('re_type'))
					$pc_form->displayError('re_type','Password must match');

				if($pc_form->get('old_pass') != $cd['PinManagerPassword'])
					$pc_form->displayError('old_pass','Password is not correct');

				$cd['PinManagerPassword']= $pc_form->get('new_password');
				$cd->save();
				$this->js()->univ()->redirect('logout')->execute();
			}
		}
		


	}
}