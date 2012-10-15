<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_MyGroups extends Model_Groups {

    function init() {
        parent::init();
        $this->_dsql()->where("(pos_id is null  Or pos_id = " . $this->api->auth->model['pos_id'] . ")");


        $this->addHook('beforeSave', $this);
    }

    function beforeSave() {
//        No Duplicate Groups allowed in PERTICULAR POS
        $ckl = $this->add('Model_MyGroups');
        $ckl->addCondition('name', $this['name']);
        if ($this->loaded())
            $ckl->addCondition('id', '<>', $this->id); // ONLY WHEN EDITING CURRENT RECORD
        $ckl->tryLoadAny();
        if ($ckl->loaded()) {
            throw $this->exception("This Group Name Already Exists, try Another Group Name");
        }
        parent::beforeSave();
    }

}