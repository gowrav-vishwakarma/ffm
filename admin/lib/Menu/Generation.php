<?php

class Menu_Generation extends Menu {
	function init(){
		parent::init();
		$this->addMenuItem('generation/slab','slabs');
	}
}