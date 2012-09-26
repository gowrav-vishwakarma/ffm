<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class page_prd_prtis extends Page {

    function init() {
        parent::init();
        $this->add('Menu_Products');
        $this->add('H1')->set("Manage Your Parties from which You purchase Products");
        
        $crud=$this->add('CRUD');
        $crud->setModel('Party');
    }

}