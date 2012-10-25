<?php
class page_downlineview extends Page {
	function init(){
		parent::init();

		$myPath=$this->api->auth->model['Path'];

		$m= $this->add('Model_Distributor');
		$m->_dsql()->where("Path like '$myPath%'");
		$m->_dsql()->order('id','DESC');
		$grid=$this->add('Grid');
		$grid->addPaginator(100);
		$grid->addQuickSearch(array('Name','id'));
		$grid->setModel($m,array('id', 'name','City','State','sponsor_id'));

	}
}