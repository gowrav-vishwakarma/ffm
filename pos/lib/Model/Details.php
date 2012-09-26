<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Details extends Model_Table{
    var $table='jos_xpersonaldetails';
    function init() {
        parent::init();
        
        $this->hasMany('Distributor','distributor_id');
    }
}