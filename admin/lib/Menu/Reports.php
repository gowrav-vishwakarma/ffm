<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Menu_Reports extends Menu{
    function init() {
        parent::init();
        $this->addMenuItem('reports/mlm',"MLM Reports");
        $this->addMenuItem('reports/kits',"Kits Reports");
        $this->addMenuItem('reports/pins',"Pins Reports");
        // $this->addMenuItem('reports/ledger',"Ledger");
    }
}