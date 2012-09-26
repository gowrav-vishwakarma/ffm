<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class page_prchs_do extends Page {

    function init() {
        parent::init();
        $this->add('Menu_Purchase');
        $this->add('H1')->set("Purchase Items and Add in Stock");

        $form = $this->add('Form');
        $form->addClass('stacked');

        $form->addField('dropdown', 'party_id')->setEmptyText("From Party")->validateNotNull("Please select a party")->setModel('Party');
        for ($i = 1; $i <= 5; $i++) {
            $form->addSeparator('atk-row');
            $itm = $form->addField('dropdown', 'item'.$i)->setEmptyText("Select Product");
            $itm->template->trySet('row_class', 'span4');
            $itm->setModel('Item');
            $form->addField('line', 'qty'.$i)->template->trySet('row_class', 'span2');
            $form->addField('line', 'rate'.$i)->template->trySet('row_class', 'span2');
            $form->addField('line', 'amount'.$i)->disable(true)->template->trySet('row_class', 'span2');
        }
        $form->addsubmit("Do Purchase");
        
        if($form->isSubmitted()){
//            PURCHASE => STOCK ENTRY => ACCOUNTS ENTRY
            $form->js()->univ()->successMessage("Doen")->execute();
        }
    }

}