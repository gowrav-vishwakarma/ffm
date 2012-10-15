<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class page_groups_my extends page_group {

    function init() {
        parent::init();
       try {
            $crud = $this->add('CRUD');
            $crud->setModel('OnlyMyGroups',null,array('id','name','head','group_id','pos'));
       } catch (Exception $e) {
       		throw $e;
           $this->js()->univ()->errorMessage($e->getMessage())->execute();
       }
    }

}