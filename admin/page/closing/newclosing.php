<?php

class page_closing_newclosing extends Page{
    function init(){
        parent::init();
        
        $form=$this->add('Form');
        $form->addField('DatePicker','new_closing');
        $form->addSubmit('Confirm');
        
        if($form->isSubmitted()){
            $this->do_closing($form->get('new_closing'));
        }
    }
    
    function do_closing($closing_name){
        $admin = $this->add('Model_Admin');
        $admin->setValue('NewJoinings','Stop');
        
        $Closing=$this->add('Model_Closing');
        
        $Closing->updatePVBinaryAndFinalize();
        $Closing->updateRPBinaryAndFinalize();
        $Closing->updateRoyaltyIncome($closing_name);
        $Closing->calculateTotalIncome($closing_name);
        $Closing->calculateDeductions($closing_name);
        $Closing->calculateNetAmount($closing_name);
        $Closing->setCarryForwardAmount($closing_name);
        $Closing->saveclosing($closing_name);
        $Closing->finish($closing_name);
        $admin->setValue('NewJoinings', 'Start');
    }
    
}