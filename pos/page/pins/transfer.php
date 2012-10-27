<?php
class page_pins_transfer extends Page {
	function init(){
		parent::init();
		$form=$this->add('Form');
		$form->addField('line','no_of_pins')->validateNotNull();
		$form->addField('dropdown','kit')->setEmptyText("Select kit")->validateNotNull("Select a kit first")->setModel('Kit');

		$form->addField('autocomplete/basic','depot')
			->setOptions(array('minLength'=>3))
			->mustMatch()
			->setNotNull()
			->setModel('Depot');

		$form->addSubmit('TRansfer Pins');

		if($form->isSubmitted()){
			$pin=$this->add('Model_Pin');
			try{
				$this->api->db->beginTransaction();
				$pin->transfer(null,$form->get('depot'),$form->get('no_of_pins'),$form->get('kit'));
			}catch(Exception $e){
				$this->api->db->rollback();
				throw $e;
				$form->js()->univ()->errorMessage($e->getMessage())->execute();
			}
			$this->api->db->commit();
			$form->js(null, $form->js()->reload())->univ()->successMessage("Pins Transfered")->execute();

		}
	}
}