<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Kit extends Model_Table {

    var $table = 'jos_xkitmaster';

    function init() {
        parent::init();

        $this->hasMany('KitLedgers','kit_id');

        $this->addField('name','Name');
        $this->addField('MRP');
        $this->addField('DP');
        $this->addField('BV');
        $this->addField('PV');
        $this->addField('RP');
        // $this->addField('AmountToIntroducer');
        $this->addField('Capping');
        $this->addField('DefaultGreen')->type('boolean')->defaultValue(false);
        $this->addField('DefaultColor')->enum(array('blue','red'))->defaultValue('blue');
        $this->addField('published')->type('boolean')->defaultValue(true);

        $this->hasMany('Distributor','kit_id');
        $this->hasMany('Pin','kit_id');

        $this->addExpression('joined_dist')->set(function($m,$q){
        	return $m->refSQL('Distributor')->count();
        });

        $this->addExpression('ledgers_count')->set(function($m,$q){
            return $m->refSQL('KitLedgers')->count();
        });
    
        $this->addHook('beforeSave',$this);
        $this->addHook('beforeDelete',$this);

    }

    function beforeSave(){

    	$m=$this->add('Model_Kit');
    	$m->addCondition('name',$this['name']);
    	if($this->loaded()){
    		$m->addCondition('id','<>',$this->id);
    	}

    	$m->tryLoadAny();
    	if($m->loaded()) throw $this->exception("Kit name already exists");
    }

    function beforeDelete(){
    	if($this['joined_dist']>0) throw $this->exception("This Kit has joined members, can not delete");
    	$this->ref('Pin')->dsql()->delete();

    }

    function doSales($no_of_kit,$to_ledger,$from_ledger=null){
        if($from_ledger==null) $from_ledger = $this->api->auth->model->ref('pos_id')->get('ledger_id');
        $KitLedgers = $this->ref('KitLedgers');
        $cr_array=array();
        $dr_array=array();
        $totalAmount=0;

        foreach($KitLedgers as $junk){
            $cr_array[$junk['ledger_id']]=array('Amount'=>($KitLedgers['Amount'] * $no_of_kit));
            $totalAmount = $totalAmount + ($KitLedgers['Amount'] * $no_of_kit);
        }

        $dr_array[$to_ledger]=array('Amount'=>$totalAmount);

        $sv=$this->add('Model_SalesVoucher');
        $sv->addVoucher($dr_array,$cr_array,true);

        $kittransfer=$this->add('Model_MyKitTransfers');
        $kittransfer['kit_id']=$this->id;
        $kittransfer['from_ledger_id']=$from_ledger;
        $kittransfer['to_ledger_id']=$to_ledger;
        $kittransfer['no_of_kits']=$no_of_kit;
        $kittransfer['order_date']=$this->api->recall('setdate',date('Y-m-d'));
        $kittransfer['is_completed']=false;
        $kittransfer['Transfered']=0;
        $kittransfer->save();

    }


}