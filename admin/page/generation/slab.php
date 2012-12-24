<?php

class page_generation_slab extends page_repurchase {
	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		if($crud->grid){
			$crud->grid->addColumn('sno','level');
		}
		$crud->setModel('GenerationSlabs');
	}
}