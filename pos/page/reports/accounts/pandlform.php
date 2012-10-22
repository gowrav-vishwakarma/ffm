<?php
class page_reports_accounts_pandlform extends page_reports {
	function init(){
		parent::init();
		$form=$this->add('Form');
		$form->addClass('stacked atk-row');
		$form->template->trySet('fieldset','span12');
		$form->addField('DatePicker','from_date')->set('1970-01-01')->setNotNull()->template->trySet('row_class','span6');
		$form->addField('DatePicker','to_date')->set($this->api->recall('setdate',date('Y-m-d')))->setNotNull()->template->trySet('row_class','span6');
		$form->addSubmit('Get P and L');

		if($form->isSubmitted()){
			if($form->get('from_date')=="") $form->displayError('from_date','From Date is must to give');
			if($form->get('to_date')=="") $form->displayError('to_date','To Date is must to give');
			$this->js()->univ()->redirect('reports_accounts_pandl',array('from_date'=>$form->get('from_date'),'to_date'=>$form->get('to_date')))->execute();
		}

	}
}