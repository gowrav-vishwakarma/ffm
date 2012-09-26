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
    }

}