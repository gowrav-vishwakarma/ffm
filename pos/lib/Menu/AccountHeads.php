<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Menu_AccountHeads extends Menu {
    function init(){
        parent::init();
        $this->addMenuItem('ledgers_my',"My Ledgers");
        $this->addMenuItem('ledgers_all',"All Ledgers");
        $this->addMenuItem('groups_my',"My Groups");
        $this->addMenuItem('groups_all',"All Groups");
    }
}