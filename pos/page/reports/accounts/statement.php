<?php
class page_reports_accounts_statement extends page_reports {
	function init(){
		parent::init();
		$form=$this->add('Form');
		$form->addField('ledger','ledger')->setGroup('root')->setNotNull();
		$form->addClass('stacked atk-row');
		$form->template->trySet('fieldset','atk-row');
		$form->addField('DatePicker','from_date')->template->trySet('row_class','span4');
		// $form->addSeparator('span2');
		$form->addField('DatePicker','to_date')->template->trySet('row_class','span4');
		$form->addSubmit("Get Account");

		$list=$this->add('Grid');
		$d=$this->add('Model_Distributor');
		$list->setModel($d,array('name','sponsor_id'));
		$list->addColumn('text','xyz');
		$list->addHook('formatRow',array($this,'formatRow'));
		$list->addPaginator(5);
	}

	function formatRow($obj){
		$obj->current_row['xyz']=rand(100,999);
	}
}