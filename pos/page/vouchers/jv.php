<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class page_vouchers_jv extends page_voucher {

    function init() {
        parent::init();
        $form=$this->add('Form');
        $form->addClass('stacked atk-row');
        $form->template->trySet('fieldset','atk-row');
        
        $form->add('H3')->set("Debit");
        $form->addSeparator('atk-row span5');
        for($i=1;$i<=3;$i++){
            $dbt=$form->addField('autocomplete/basic','dbtlgr_'.$i,'Debit Account'.$i);
            // $dbt->setEmptyText("-");
            // $dbt->js(true)->combobox();
            $dbt->setModel('MyLedgers');
            $form->addField('line','dbtamt_'.$i,'DbtAmt');
        }
        
        
        $form->addSeparator('span5');       
        $form->add('H3')->set("Credit");
        for($i=1;$i<=3;$i++){
            $crd=$form->addField('autocomplete/basic','crdlgr_'.$i,'Account'.$i);//->setEmptyText(" ");
            // $crd->js(true)->combobox();
            $crd->setModel('MyLedgers');
            $form->addField('line','crdamt_'.$i,'Amt'.$i);
        }
        
        $form->addField("text","narration");
        
        $form->addSubmit();
        if($form->isSubmitted()){
            
//            CHECK POSSIBLE ERRORS @TODO@
            
//            CREATE ARRAYS
            $dr_array=array();
            $cr_array=array();
            for($i=1;$i<=3;$i++){
                $dr_array[$form->get('dbtlgr_'.$i)]=array('Amount'=>$form->get('dbtamt_'.$i));
                $cr_array[$form->get('crdlgr_'.$i)]=array('Amount'=>$form->get('crdamt_'.$i));
            }
            
            $jv=$this->add('Model_JournalVoucher');
            $jv->addVoucher($dr_array, $cr_array, true,null,null,$form->get('narration'));
            $form->js(null,$form->js()->reload())->univ()->successMessage("JV Entered")->execute();
        }
    }

}