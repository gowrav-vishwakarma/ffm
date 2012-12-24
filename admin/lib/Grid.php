<?php


class Grid extends Grid_Advanced{
	public $mysno=1;

	function format_sno($field){
		$this->current_row[$field] = $this->mysno + $_GET[$this->name.'_paginator_skip'];
		$this->mysno++;
	}
}