<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class page_group extends Page {

    function init() {
        parent::init();
        $this->add('Menu_AccountHeads');
    }

}