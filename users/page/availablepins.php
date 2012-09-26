<?php

class page_availablepins extends Page {
	function init(){
		parent::init();

		$this->api->stickyGET('show_pins');

		$form=$this->add('Form');

		$grid=$this->add('Grid');

		$m=$this->api->auth->model->ref('Pin');
		$m->addCondition('Used',false);

		$grid->setModel($m);

		if($_GET['show_pins']){

		}else{
			$m->addCondition('Pin','0');
		}

		// $m->debug();

		$form->addField('password','pin_password');
		$form->addSubmit("Get My Pins");

		$grid->addPaginator(10);

		if($form->isSubmitted()){

			if($form->get('pin_password') != $this->api->auth->model['PinManagerPassword'])
				$form->displayError('pin_password',"The Password looks wrong");

			$grid->js(null,$form->js()->reload())->reload(array("show_pins"=>1))->execute();
		}

	}
}