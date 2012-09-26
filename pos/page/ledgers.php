<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class page_ledgers extends Page {

    function init() {
        parent::init();
        $this->add('Menu_AccountHeads');
    }

}