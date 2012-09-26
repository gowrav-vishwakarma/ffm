<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Staff extends Model_Table {

    var $table = 'jos_xxstaff';

    function init() {
        parent::init();
        $this->addField('name')->mandatory("name is must for staff");
        $this->addField('username')->mandatory("User Name is must to give");
        $this->addField('password')->mandatory("User Name is must to give");
        $this->addField('AccessLevel');//->mandatory("User Name is must to give");
        
        $this->hasOne('Pos','pos_id');
        $this->hasMany('LedgerCreated','staff_id');
        
    }

}