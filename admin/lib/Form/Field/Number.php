<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Form_Field_Number extends Form_Field_Line {
	function validate() {
            if(!is_numeric($this->value))
                $this->displayFieldError("This field reqiores a number");
            return parent::validate();
        }
        function getInput($attr=array()){
		return parent::getInput(array_merge(array('type'=>'text'),$attr));
	}
}