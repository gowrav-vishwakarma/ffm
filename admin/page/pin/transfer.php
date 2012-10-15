<?php
class page_pin_transfer_1 extends Page {
	function init(){
		parent::init();
		$form = $this->add('Form');
		$form->addField('line','from_id');
		$form->addField('line','to_id');
		$form->addField('autocomplete/basic','to_distributor')->setOptions(array('minLength'=>3))->mustMatch()->setNotNull()->setModel('Distributor');
		$form->addSubmit("Transfer");

		if($form->isSubmitted()){
			$pin=$this->add('Model_Pin');
			try{
				$this->api->db->beginTransaction();
				$pin->transfer($form->get('from_id'),$form->get('to_id'),$form->get('to_distributor'));
			}catch(Exception $e){
				$this->api->db->rollback();
				throw $e;
				$form->js()->univ()->errorMessage($e->getMessage())->execute();
			}
			$this->api->db->commit();
			$form->js(null, $form->js()->reload())->univ()->successMessage('Pins Transfered')->execute();
		}
	}
}