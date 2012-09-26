<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_PosOwner extends Model_Distributor {

    function init() {
        parent::init();
        $this->hasMany("Pos","owner_id");
    }

}