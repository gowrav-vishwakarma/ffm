<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Leg extends Model_Table {

    var $table = 'jos_xlegs';

    function init() {
        parent::init();
        $this->hasOne("Distributor",'distributor_id');
        $this->hasOne("Distributor",'downline_id');
    }

}