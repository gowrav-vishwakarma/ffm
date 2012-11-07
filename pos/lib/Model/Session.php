<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Session extends Model_Table {

    var $table = 'jos_xclosingsession';

    function init() {
        parent::init();
        $this->hasOne('Distributor','distributor_id');
		$this->addField('SessionLeftPV');
		$this->addField('SessionRightPV');
		$this->addField('SessionPairPV');
		$this->addField('SessionPairBV');
		$this->addField('SessionLeftRP');
		$this->addField('SessionRightRP');
		$this->addField('SessionPairRP');
		$this->addField('SessionIntros');
		$this->addField('SessionGreenCount');
		$this->addField('SessionLeftCount');
		$this->addField('SessionRightCount');
		$this->addField('TotalGreenCount');
		$this->addField('TotalCount');
		$this->addField('Session');
    }

}