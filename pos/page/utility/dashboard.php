<?php
class page_utility_dashboard extends Page {
	function init(){
		parent::init();

		$tabs=$this->add('Tabs');
		$datetab=$tabs->addTab('Change Date');
		$form=$datetab->add('Form');
		$form->addField('DatePicker','change_date_to');
		$form->addSubmit("Change Date");
		if($form->isSubmitted()){
			$this->api->memorize('setdate',$form->get('change_date_to'));
			$form->js()->univ()->redirect(".")->execute();
		}
	}
}