<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_LedgerAll extends Model_Table {

    var $table = 'jos_xxledgers';

    function init() {
        parent::init();
        $this->addField('name')->mandatory("Ledger must have a name");
        // $this->addField('OpBalCR')->type('Number');//->defaultvalue(0.00);
        // $this->addField('OpBalDR')->defaultvalue(0.00);
        $this->addField('created_at')->defaultValue(date('Y-m-d'))->system(true);
        $this->addField('updated_at')->defaultValue(date('Y-m-d'))->system(true);
        $this->addField('default_account')->type('boolean')->defaultValue(false)->system(true);
        
        $this->hasOne('Groups','group_id');
        $this->hasOne('Distributor','distributor_id')->system(true);
        $this->hasOne('Pos','pos_id')->system(true);
        $this->hasOne('Staff','staff_id')->system(true);
        $this->hasMany('MyContraVouchers','ledger_id');
        $this->hasMany('MyKitsToGive','from_ledger_id');
        $this->hasMany('MyKitsToTake','to_ledger_id');
        
        // $this->addExpression("CurrentBalance")->set('OpBalCR - OpBalDR');
        
        
        $this->addHook('beforeDelete',$this);
        $this->addHook('beforeSave',$this);
    }
    
    function beforeDelete(){
//        ONLY DELETE YOUR OWN LEDGER UNLESS YOU ARE ACCESS LEVEL ABOVE 500
        if($this->api->auth->model['AccessLevel'] < 500 AND $this['pos_id'] == NULL)
            throw $this->exception("You Are not Allowed to delete such a ledger");
        
        if($this->api->auth->model['pos_id'] != $this['pos_id'])
            throw $this->exception("You are trying to delete a Ledger which is not in your POS");

        // @TODO@ -- Disallow to delete ledger with transactions

    }
    
    function beforeSave(){
        
    }
    
    function getDeafultLedgerID($ledger){
        $this->_dsql()->del('where');
        $this->addCondition('name',$ledger);
        $this->addCondition('default_account',true);
        $this->tryloadAny();
        $id=$this->id;
        if($this->loaded()) {
            $this->unload();
            return $id;
        }else{
            throw $this->exception("Could not get id for Ledger $ledger");
        }
    }    


    function getDistributorLedger($distributor_id){
        $this->addCondition('distributor_id',$distributor_id);
        $this->addCondition('default_account',true);
        $this->addCondition('pos_id','is',null);
        $this->loadAny();
    }

}