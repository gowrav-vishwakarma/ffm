<?php
class page_distributor extends Page {
	function init(){
            parent::init();

            $tab=$this->add('Tabs');
            $tab->addTabURL('distributor_search','Search');
            $tab->addTabURL('distributor_sms','SMS');
            $tab->addTabURL('distributor_idshift','ID Shift');
        
            
        }
        
    }
        