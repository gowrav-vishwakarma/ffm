<?php

/* I m here changed
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Admin extends Model_Table {

	var $table = 'jos_xadmin';

	function init() {
		parent::init();
		$this->addField( "Command" )->mandatory( "Command is must to give" );
		$this->addField( "Values" )->mandatory( "Command is must to give" );

	}

	function getValue($command){
		$this->addCondition('Command',$command);
		$this->loadAny();
		return $this['Values'];
	}

	function setValue($command,$value){
		$this->addCondition('Command',$command);
		$this->loadAny();
		$this['Values']=$value;
		$this->save();
	}
}
