<?php
class page_ledgers extends Page {
	function init(){
		parent::init();
		$this->add("Menu_AccountHeads");
	}
}