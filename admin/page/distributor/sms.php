<?php
class page_distributor_sms extends Page{
    function init(){
        parent::init();
        
        $tab=$this->add('Tabs');
       $t= $tab->addTab('By Distributor ID');
       $m= $tab->addTab('By Distributor Mobile Number');
       
       $d=$this->add('Model_Distributor');
       $form=$t->add('Form');
       $form->addField('autocomplete/basic','distributor_id')->setModel($d);
       $form->addField('text','message');
       $form->addSubmit("Send");
       if($form->isSubmitted()){
           $form->js()->univ()->successMessage("Message Successfully Send By Distributor ID ")->execute();
       }
       
       
       $form1=$m->add('Form');
       $form1->addField('line','MobileNo');
       $form1->addField('text','Message');
       $form1->addSubmit('Send');
       
        if($form1->isSubmitted()){
           $form1->js()->univ()->successMessage("Message Successfully Send By Distributor ID ")->execute();
       }
       }
}