<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_OnlyMyLedgers extends Model_MyLedgers {

    function init() {
        parent::init();
        $this->_dsql()->del('where');
        $this->addCondition('pos_id',$this->api->auth->model['pos_id']);
        $this->addHook('beforeSave',$this);
        $this->addHook('beforeDelete',$this);
        
    }
    
    function beforeSave() {
        $this['staff_id']=$this->api->auth->model->id;
        parent::beforeSave();
        
    }
    
    function beforeDelete() {
        parent::beforeDelete();
    }
}