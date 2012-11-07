<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_OnlyMyGroups extends Model_MyGroups {
    function init() {
        parent::init();
        
        $this->_dsql()->del('where');
        $this->addCondition('pos_id',$this->api->auth->model['pos_id']);
        $this->addCondition('lft','<>', 0);
        
        $this->addHook("beforeSave", $this);
        // $this->debug();
    }
    
    function beforeSave() {
        parent::beforeSave();
    }
}