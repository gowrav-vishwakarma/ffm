<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class page_ledgers_my extends page_ledgers {

    function init() {
        parent::init();
        // try{
	        $crud=$this->add('CRUD');
    	    $crud->setModel('OnlyMyLedgers');
        // }  catch (Exception $e){
        //     $this->js()->univ()->errorMessage($e->getMessage())->execute();
        // }
    }

}