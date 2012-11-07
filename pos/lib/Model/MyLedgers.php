<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_MyLedgers extends Model_Ledger {
    function init() {
        parent::init();
        $this->_dsql()->where("(pos_id is null  Or pos_id = ".$this->api->auth->model['pos_id'].")");
        
        
        $this->addHook('beforeSave',$this);
        $this->addHook('beforeDelete',$this);
    }
    
    function beforeSave(){
//        No Duplicate Ledgers allowed in PERTICULAR POS
        $ckl=$this->add('Model_MyLedgers');
        $ckl->addCondition('name',$this['name']);
        if($this->loaded()) $ckl->addCondition('id','<>',$this->id); // ONLY WHEN EDITING CURRENT RECORD
        $ckl->tryLoadAny();
        if($ckl->loaded()){
            throw $this->exception("This Account Name Already Exists, try Another Ledger Name");
        }
        
//        Ledger not alllowed to start with pos_ if Access Level is < 500
        if(strpos(strtolower($this['name']),"pos_") !== false AND $this->api->auth->model['AccessLevel'] < 500){
            throw $this->exception("You Cannot Create Ledgers starting with 'pos_'");
        }
        
        parent::beforeSave();
    }
    
    function beforeDelete() {
        parent::beforeDelete();
    }

}