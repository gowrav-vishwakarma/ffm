<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class page_ledgers_all extends page_ledgers {

    function init() {
        parent::init();
        $grid=$this->add('Grid');
        $grid->setModel('MyLedgers',array('name','OpBalCR','OpBalDR','group','CurrentBalance','default_account'));
        $grid->addPaginator(50);
        $grid->addQuickSearch();
    }

}