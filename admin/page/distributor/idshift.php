<?php
class page_distributor_idshift extends Page{
    function init(){
        parent::init();
        $d=$this->add('Model_Distributor');
        $form=$this->add('Form');
        $form->addField('autocomplete/basic','id_shift')->mustMatch()->setModel($d);
        $form->addField('autocomplete/basic','new_sponor')->mustMatch()->setModel($d);
        $form->addSubmit('Shift');
        
        if($form->isSubmitted()){
            $form->js()->univ()->errorMessage("This functionalty Not Implemented Yet ")->execute();
        }
    }
}