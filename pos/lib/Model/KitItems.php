<?php
class Model_KitItems extends Model_Table {
	var $table= "jos_xxkititems";
	function init(){
		parent::init();
		$this->hasOne('Kit','kit_id')->mandatory("Kit is must");
		$this->hasOne('Item','item_id')->mandatory("Item is must");
		$this->addField('Qty')->mandatory("Quantity is must");
	}
}