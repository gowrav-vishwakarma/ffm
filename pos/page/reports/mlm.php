<?php
class page_reports_mlm extends page_reports {
	function init(){
		parent::init();

		$tabs=$this->add('Tabs');
		$tabs->addTabURL('reports_mlm_total','OverAll Report');
	}
}