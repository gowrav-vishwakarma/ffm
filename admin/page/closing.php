<?php

class page_closing extends Page{
    function init(){
        parent::init();
        
        $tab=$this->add('Tabs');
        $tab->addTabURL('closing_details', 'Payment Details');
        $tab->addTabURL('closing_newclosing', 'New Closing');
    }
}