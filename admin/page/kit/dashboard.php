<?php 
class page_kit_dashboard extends Page{
	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		$crud->setModel('Kit');
	}
}