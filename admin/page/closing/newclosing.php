<?php

class page_closing_newclosing extends Page{
    function init(){
        parent::init();
        
        $form=$this->add('Form');
        $form->addField('DatePicker','new_closing')->validateNotNull();
        $form->addField('checkbox','perform_royalty_closing');
        $form->addField('checkbox','perform_repurchase_closing');
        $form->addSubmit('Confirm');
        
        if($form->isSubmitted()){
            
            $this->do_closing($form->get('new_closing'), $form->get('perform_royalty_closing'),$form->get('perform_repurchase_closing'));
            
            $form->js(null,$form->js()->univ()->successMessage("Closing Done"))->reload()->execute();
        }
    }
    
    function do_closing($closing_name,$do_royalty=false,$do_repurchase=false){
        
        $admin = $this->add('Model_Admin');
        $admin->setValue('NewJoinings','Stop');
        
        $Closing=$this->add('Model_Closing');
        
        $Closing->updatePVBinaryAndFinalize();
        $Closing->updateRPBinaryAndFinalize();
        
        if($do_royalty)
            $Closing->updateRoyaltyIncome($closing_name);
        
        if($do_repurchase)
            $Closing->updateRepurchaseIncome($closing_name);
 
        $Closing->calculateTotalIncome($closing_name);
        
        $Closing->calculateDeductions($closing_name);
        
        $Closing->calculateNetAmount($closing_name);
        $Closing->setCarryForwardAmount($closing_name);
        $Closing->saveclosing($closing_name);
        $Closing->finish($closing_name);
        $Closing->createCommissionVouchers($closing_name);
        $admin->setValue('NewJoinings', 'Start');
        
    }
    
}