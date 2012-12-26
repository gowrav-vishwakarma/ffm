<?php

class Form_Field_readonly extends Form_Field_Line {
	function getInput($attr=array()){
		return parent::getInput(array_merge(array('readonly'=>'readonly'),$attr));
	}
}