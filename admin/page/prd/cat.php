<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class page_prd_cat extends Page {

    function init() {
        parent::init();
        $this->add('Menu_Products');
        $this->add('H1')->set("Manage Products Categories Here");
        $crd=$this->add('CRUD');
        $crd->setModel('Category');
    }

}