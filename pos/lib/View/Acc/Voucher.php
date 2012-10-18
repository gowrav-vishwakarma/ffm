<?php

class View_Acc_Voucher extends CompleteLister{
	function init(){
		parent::init();
	}

	function formatRow(){
		$this->current_row['xyz']=strlen($this->current_row['name']);
	}

	function addPaginator($ipp=25){
        // adding ajax paginator
        $this->paginator=$this->add('Paginator');
        $this->paginator->ipp($ipp);
        return $this;
    }

	function defaultTemplate(){
		return array('view/list/voucher');
	}
}