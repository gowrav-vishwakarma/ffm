<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Head extends Model_Table {

    var $table = 'jos_xxheads';

    function init() {
        parent::init();
        $this->hasMany("groups");
        $this->addField("name")->mandatory("Must have a Name");
        $this->addField("type")->mandatory("Must have");
        $this->addField("isPANDL")->type("boolean");
        $this->hasMany('MyGroups','head_id');
    }

}