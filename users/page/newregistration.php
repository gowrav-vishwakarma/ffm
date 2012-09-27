<?php
class page_newregistration extends Page {
	function init(){
		parent::init();
	
		$form=$this->add('Form');
		$form->setModel('Distributor',array('distributor_id','pin','sponsor_id','name',
							'father/husband_name','date_of_birth','password','retype_password','mobile_no',
							'address','city','state','pin_code','nominee','relation_with_nominee'),'pan_no',
							'your_bank','IFSC_code','account_number');
		// $form->addField('line','distributor_id');
		// $form->addField('line','pin');
		// $form->addField('line','sponsor_id');
		// $form->addField('line','name');
		// $form->addField('line','father/husband_name');
		// $form->addField('DatePicker','date_of_birth');
		// $form->addField('password','password');
		// $form->addField('line','name');

	}
}