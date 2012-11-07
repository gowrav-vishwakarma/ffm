<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Stock extends Model_Table {

    var $table = 'jos_xxstocks';

    function init() {
        parent::init();
        $this->hasOne("Item","item_id");
        $this->hasOne("Pos","pos_id");
        $this->addField("Stock");
    }


}