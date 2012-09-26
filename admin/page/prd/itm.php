<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class page_prd_itm extends Page {

    function init() {
        parent::init();
        $this->add('Menu_Products');
        
        $this->add('H1')->set("Manage Products Here");
        $crd=$this->add('CRUD');
        $crd->setModel("Item");
        
    }

}