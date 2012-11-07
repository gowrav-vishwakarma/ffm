<?php
class Model_UsedPins extends Model_Pin {
	function init(){
		parent::init();

		$dis=$this->Join('jos_xtreedetails.pin_id')->join('jos_xpersonaldetails.distributor_id');
        $dis->addField('joining_of', 'distributor_id')->caption('Joining Of');
        $dis->addField('Name')->caption('Joined Person');


	}
}