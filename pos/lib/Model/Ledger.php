<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Ledger extends Model_LedgerAll {
    
    function init() {
        parent::init();
        $this->addHook("beforeDelete", $this);
        $this->addHook('beforeSave',$this);
    }
    
    function beforeDelete() {
        parent::beforeDelete();
    }
    
    function beforeSave() {
        parent::beforeSave();
    }
    
}