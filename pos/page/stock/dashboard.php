<?php
class page_stock_dashboard extends page_stock {
	function init(){
		parent::init();
		$grid=$this->add('Grid');
		$grid->setModel('MyStocks',array('item','Stock'));
	}
}