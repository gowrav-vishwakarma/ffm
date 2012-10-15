<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class page_groups_all extends page_group {

    function init() {
        parent::init();
        $grid=$this->add('Grid');
        $grid->setModel('MyGroups',array('id','name','head','group_id','pos') );
    }

}