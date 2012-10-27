<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Pos extends Model_Table {

    var $table = 'jos_xxpos';

    function init() {
        parent::init();
        $this->hasOne("PosOwner",'owner_id')->display(array('form'=>'autocomplete/basic'));
        $this->hasOne('LedgerAll','ledger_id')->system(true);
        
        $this->addField('name')->mandatory("Point of Sales Must have a Name");
        $this->addField("type")->enum(array("Retailer","Depot"))->defaultValue("Retailer")->mandatory("Type of POS is must to specify");

        $this->hasMany("MyStocks","pos_id");
        $this->hasMany('Staff','pos_id');
        $this->hasMany('OnlyMyGroups','pos_id');
        $this->hasMany('OnlyMyLedgers','pos_id');
        $this->hasMany('VoucherAll','pos_id');
        $this->hasMany('MyVouchers','pos_id');
        
        $this->addHook("beforeSave", $this);
        $this->addHook("afterSave", $this);
        
        $this->addHook("beforeDelete", $this);
        
    }
    
    function beforeSave(){
        if(!$this->loaded()) { //New Entry Saving
            $this->memorize("isNew", true);
        }else{
//            DISABLE MAIN POS EDITING
            // if($this->id == 1 or $this->recall('reset_mode',false))
            //     throw $this->exception("You cannot Modify Company POS made default ".$this['type']);
        }
    }
    
    function afterSave(){
        if($this->recall('isNew',false)){ //If Coming After saving New
            $this->forget('isNew');

            $this->setupAccounting(); 
            $this->createDefaultStaff();
            
        }
    }
    
    function beforeDelete(){
        if($this['type']=='COMPANY')
            throw $this->exception("Oops no delete please");
    }
    
    function setupAccounting(){
        
        $l=$this->add('Model_Ledger');
        $l['name']="pos_".$this['name'];
        $l['group_id']= 12 ;    /*Branches And Division*/ //@TODO@ -- in which group it has to be
        $l['distributor_id']=$this['owner_id'];
        $l['default_account']=true;
        $l->save();

        $this['ledger_id']=$l->id;
        $this->save();
    }
    
    function createdefaultStaff(){
//        @TODO@
        $s=$this->add('Model_Staff');
        $s['name']=$this['name'] . "_SUPER_STAFF";
        $s['username']='pos_'.$this['id']."_admin";
        $s['password']='admin';
        $s['AccessLevel']='100';
        $s['pos_id']=$this->id;
        $s->save();
    }
    
    function getNextVoucherNumber($voucher_type){
        $v=$this->api->db->dsql()
                ->table('jos_xxvouchers')
                ->field($this->dsql()->expr('MAX(VoucherNo)'))
                ->where('pos_id',$this->id)
                ->where('VoucherType',$voucher_type)
                ->do_getOne();
        return (++$v);
    }
    
    function getCurrent(){
        $loggedin_pos=$this->api->auth->model['pos_id'];
        $this->load(($loggedin_pos==0)?1:$loggedin_pos);
    }

    function addStock($item,$qty){
        $stockmodel=$this->ref('MyStocks')->addCondition('item_id',$item);
        $stockmodel->tryloadAny();
        if(!$stockmodel->loaded()) { //No entry for this pos and otem yet
            $stockmodel=$this->add('Model_MyStocks');
            $stockmodel['item_id']=$item;
            $stockmodel['Stock']=0;
        }
        $stockmodel['Stock'] += $qty;
        $stockmodel->saveAndUnload();
    }

    

}