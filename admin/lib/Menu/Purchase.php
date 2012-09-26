<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Menu_Purchase extends Menu{
    function init() {
        parent::init();
        
        $this->addMenuItem('prd_dsh',"Back");
        $this->addMenuItem('prchs_dsh',"Purchase DashBoard");
        $this->addMenuItem('prchs_ordr',"Purchase Orders");
        $this->addMenuItem('prchs_do',"Purchase");
    }
}
