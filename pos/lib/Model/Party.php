<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Party extends Model_Table {

    var $table = 'jos_xxparties';

    function init() {
        parent::init();
        $this->addField("name")->mandatory("Party Name is Must to give");
        $this->addField("Address");
        $this->addField("MobileNumber");
        
    }

}