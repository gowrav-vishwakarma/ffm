<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Menu_Pos extends Menu{
    function init(){
        parent::init();
        
        $this->addMenuItem('pos','Pos DashBoard');
    }
}