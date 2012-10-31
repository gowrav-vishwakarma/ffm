<?php 
class page_kit_dashboard extends Page{

	function page_index(){
		// parent::init();

		$crud=$this->add('CRUD',array("allow_edit"=>false));
		$crud->setModel('Kit');
		if($crud->grid){
			$crud->grid->addColumn('expander','ledgers');
			$crud->grid->addColumn('expander','items');
			$crud->grid->addTotals(array('joined_dist'));
		}
	}

	function page_ledgers(){
		$this->api->stickyGET('id');
		$crud=$this->add('CRUD');
		$m=$this->add('Model_Kit');
		$m->load($_GET['id']);

		$crud->setModel($m->ref('KitLedgers'));
		if($crud->form){
			$crud->form->getElement('ledger_id')->setGroup('Branches And Divisions');
		}
	}

	function page_items(){
		$this->api->stickyGET('id');
		$crud=$this->add('CRUD');
		$m=$this->add('Model_Kit');
		$m->load($_GET['id']);

		$crud->setModel($m->ref('KitItems'));
		// if($crud->form){
		// 	$crud->form->getElement('ledger_id')->setGroup('Branches And Divisions');
		// }
	}

}