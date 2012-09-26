<?php
class page_sessionview extends Page {
	function init(){
		parent::init();

		$this->add('H2')->set("Current Position");
		$cur_grid=$this->add('Grid');
		$cur_grid->setModel($this->api->auth->model->ref('Leg'),array('Leg','SessionPV'));

		$this->add('H2')->set("Your Session Details");
		$grid=$this->add("Grid");
		$grid->setModel($this->api->auth->model->ref('Session'),array('Session','SessionLeftPV','SessionRightPV','SessionLeftCount','SessionRightCount','SessionPairPV'));
		$grid->dq->order('Session','Desc');
		$grid->addQuickSearch(array('Session'));
		$grid->addPaginator(100);

		


	}
}