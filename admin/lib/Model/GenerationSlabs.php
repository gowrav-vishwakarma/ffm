<?php
class Model_GenerationSlabs extends Model_Table{
	var $table ="jos_xxbvslab";
	function init(){
		parent::init();
		$this->addField('name')->caption('Slab Percentage')->type('number')->mandatory("it is must");
		$this->addHook('beforeSave',$this);
		// $this->_dsql()->order('id','asc');
	}
	function beforeSave(){
		if($this['name'] <= 0) throw $this->exception('Only Positive numbers are allowed');
	}
}