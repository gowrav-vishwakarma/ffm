<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class page_pos extends Page {

    function init() {
        parent::init();
        $this->add('Menu_Pos');
        
        $this->add('H1')->set("Manage Your Point Of sales Here ");
        $crud=$this->add('CRUD');
        $crud->setModel('Pos');
        
    }

}