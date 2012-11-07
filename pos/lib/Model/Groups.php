<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Groups extends Model_GroupsAll {

    function init() {
        parent::init();
        $this->addCondition('lft', '<>', 0);
        $this->addHook("beforeSave", $this);
    }
    
    function beforeSave(){
        parent::beforeSave();
    }

}