<?php
class page_newregistration extends Page {
	function init(){
		parent::init();
		
		$form=$this->add('Form');
		$form->setModel('Distributor');		
	}
}