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
        $this->addMenuItem('reports/accounts/ledger',"Ledger");
        // $this->addMenuItem('reports/accounts/statement',"Account Statement");
        $this->addMenuItem('reports/accounts/pandlform',"P & L");
        $this->addMenuItem('reports/accounts/balancesheetform',"Balance Sheet");
        $this->addMenuItem('reports/accounts/daybook',"Day Book");
        // $this->addMenuItem('reports/accounts/cashbook',"Cash Book");
    }
}