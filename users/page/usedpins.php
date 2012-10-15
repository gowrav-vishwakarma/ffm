<?php

class page_usedpins extends Page {
	function init(){
		parent::init();


		$m=$this->api->auth->model->ref('UsedPins');
		$m->addCondition('Used',true);
		$grid=$this->add('Grid');
		$grid->setModel($m,array('Pin','Name','joining_of'));
		$grid->addPaginator(10);
		$grid->addQuickSearch(array('Pin','joining_of','Name'));
	}
}