<?php

class Menu_Stock extends Menu{
	function init(){
		parent::init();
		$this->addMenuItem('stock/dashboard',"Dashboard");
	}
}