<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Pin extends Model_Table {

    var $table = 'jos_xpinmaster';

    function init() {
        parent::init();
        $this->hasOne('PosOwner','adcrd_id');
        $this->hasOne('Kit','kit_id');
        $this->hasOne('Pos','pos_id');
        $this->addField('BV');
        $this->addField('PV');
        $this->addField('RP');

        $this->addField('Pin');

        $this->addField('Used')->type('boolean')->defaultValue(false);
        $this->addField('published')->type('boolean')->defaultValue(false);
        $this->addField('created_at')->type('date')->defaultValue(date('Y-m-d H:i:s'))->system(true);
        $this->addField('updated_at')->type('date')->defaultValue(date('Y-m-d H:i:s'))->system(true);

        $this->addField('under_pos')->type('boolean')->defaultValue(true);

        $this->addExpression('distributor_id')->set('id');

        $this->addHook('beforeSave',$this);

    }

    function beforeSave(){
        $this['updated_at']=date('Y-m-d H:i:s');
    }

    function generateAndSave($kit_id,$bv,$pv,$rp,$adcrd_id){
    	
    	$this['kit_id']=$kit_id;
    	$this['BV']=$bv;
    	$this['PV']=$pv;
    	$this['RP']=$rp;
        $this['adcrd_id']=$adcrd_id;
    	$this['pos_id']=$adcrd_id;


    	do{
    		// if(isset($temp)) $temp->destroy();
	    	$temp=$this->add('Model_Pin');
	    	$pin=rand(1000,9999). "-" . rand(1000,9999) . "-".rand(1000,9999) . "-". rand(1000,9999);
	    	$temp->addCondition('Pin',$pin);
	    	$temp->tryLoadAny();
	    	if(!$temp->loaded()) break;
	    	$temp->distroy();
    	}while(1);

    	$this['Pin']=$pin;

    	$this->saveAndUnload();
    }

    function usePin($pin=null){
        if($pin==null and !$this->loaded()) return false;
        if($this['Used']==true) return false;

        if(!$this->loaded() and $pin != null){
            $this->addCondition('Pin',$pin);
            $this->tryLoadAny();
            if(!$this->loaded()) return false;
        }

        $this['Used']=true;
        $this['updated_at']=true;

        $this->save();

    }

    function transfer($from_pos=null,$to_pos,$noofpins,$kit,$to_type='Pos'){
        if($from_pos == null) $from_pos = $this->api->auth->model['pos_id'];

        $pin=$this->add('Model_Pin');
        $pin->addCondition('kit_id',$kit);
        $pin->addCondition('Used',false);
        $pin->addCondition('pos_id',$from_pos);
        if($pin->count()->do_getOne() < $noofpins)
            throw $this->exception("There are not sufficient unused pins to transfer");

        // $pin=$this->add('Model_Pin');
        // $pin->addCondition('kit_id',$kit);
        // $pin->addCondition('Used',false);
        // $pin->addCondition('pos_id',$from_pos);

        $q="UPDATE jos_xpinmaster SET pos_id=$to_pos 
            WHERE 
                kit_id= $kit and Used= 0 AND pos_id = $from_pos
            LIMIT $noofpins
                ";
        $this->api->db->dsql()->expr($q)->execute();
        
        // $pin->_dsql()->set('pos_id',$to_pos)->limit($noofpins)->update();
        // $pin->debug();
        // @TODO@ -- add entry in pin transfer table
        // @TODO@ -- Kit transfer entry to manage kits transfered or not.
        $kt=$this->add('Model_KitTransfers');
        $kt['kit_id']=$kit;
        $kt['from_pos_id']=$from_pos;
        $kt['to_pos_id']=$to_pos;
        $kt['no_of_kits']=$noofpins;
        $kt->save();

    }

    function SalesToPOS($to_pos,$noofpins,$kit){

        $pos=$this->add('Model_Pos');
        $pos->load($to_pos);

        $pin=$this->add('Model_Pin');
        $pin->addCondition('kit_id',$kit);
        $pin->addCondition('Used',false);
        $pin->addCondition('pos_id',$this->api->auth->model['pos_id']);
        $pin->addCondition('under_pos',true);
        if($pin->count()->do_getOne() < $noofpins)
            throw $this->exception("There are not sufficient unused pins to transfer");

        $pin=$this->add('Model_Pin');
        $pin->addCondition('kit_id',$kit);
        $pin->addCondition('Used',false);
        $pin->addCondition('under_pos',true);
        $pin->addCondition('pos_id',$this->api->auth->model['pos_id']);

        $i=1;
        foreach($pin as $junk){
            $pin['adcrd_id']=$to_dist;
            $pin['under_pos']=1;
            $pin['adcrd_id']=$pos['owner_id'];
            $pin['pos_id']=$to_pos;
            $pin->saveAndUnload();
            $i++;
            if($i>$noofpins) break;
        }

        // $pin->_dsql()->set('pos_id',$to_pos)->set('under_pos',1)->set('adcrd_id',$pos['owner_id'])->limit($noofpins)->update();

        $pinkit=$this->add('Model_Kit');
        $pinkit->load($kit);

        $pos=$this->add('Model_Pos');
        $pos->load($to_pos);

        $pinkit->doSales($noofpins,$pos['ledger_id']);

    }

    function SalesToDIST($to_dist,$noofpins,$kit){
        $pin=$this->add('Model_Pin');
        $pin->addCondition('kit_id',$kit);
        $pin->addCondition('Used',false);
        $pin->addCondition('pos_id',$this->api->auth->model['pos_id']);
        $pin->addCondition('under_pos',true);

        if($pin->count()->do_getOne() < $noofpins)
            throw $this->exception("There are not sufficient unused pins to transfer");

        $pin=$this->add('Model_Pin');
        $pin->addCondition('kit_id',$kit);
        $pin->addCondition('Used',false);
        $pin->addCondition('pos_id',$this->api->auth->model['pos_id']);
        $pin->addCondition('under_pos',true);

        $i=1;
        foreach($pin as $junk){
            $pin['adcrd_id']=$to_dist;
            $pin['under_pos']=0;
            $pin->saveAndUnload();
            $i++;
            if($i>$noofpins) break;
        }
        // throw $this->exception($pin->_dsql()->set('adcrd_id',$to_dist)->set('under_pos',0)->limit($noofpins)->render());//->update();

        $pinkit=$this->add('Model_Kit');
        $pinkit->load($kit);

        $dist_ledger=$this->add('Model_LedgerAll');
        $dist_ledger->addCondition('distributor_id',$to_dist);
        $dist_ledger->addCondition('pos_id','is', null);
        $dist_ledger->addCondition('default_account',true);
        // $dist_ledger->debug();
        $dist_ledger->loadAny();

        $pinkit->doSales($noofpins,$dist_ledger->id);

    }

    function singleSaleToDIST($to_dist,$narration=null){
        $this['adcrd_id'] = $to_dist;
        $this['under_pos']=0;
        $this->save();

        $pinkit=$this->ref('kit_id');
        

        $dist_ledger=$this->add('Model_LedgerAll');
        $dist_ledger->addCondition('distributor_id',$to_dist);
        $dist_ledger->addCondition('pos_id','is', null);
        $dist_ledger->addCondition('default_account',true);
        // $dist_ledger->debug();
        $dist_ledger->loadAny();

        $pinkit->doSales(1,$dist_ledger->id,$this->ref('pos_id')->get('ledger_id'),$narration);

    }

    function saleFromDistToDist($from_dist=null,$to_dist,$noofpins=1,$narration,$on_date){
        
        if($from_dist == null) $from_dist = $this['adcrd_id'];

        $pin=$this->add('Model_Pin');
        $pin->addCondition('kit_id',$this->ref('kit_id')->id);
        $pin->addCondition('Used',false);
        $pin->addCondition('adcrd_id',$from_dist);
        // $pin->addCondition('pos_id',$this->api->auth->model['pos_id']);
        $pin->addCondition('under_pos',false);

        if($pin->count()->do_getOne() < $noofpins)
            throw $this->exception("There are not sufficient unused pins to transfer");

        // $pin=$this->add('Model_Pin');
        // $pin->addCondition('kit_id',$this->ref('kit_id')->id);
        // $pin->addCondition('Used',false);
        // $pin->addCondition('adcrd_id',$from_dist);
        // $pin->addCondition('pos_id',$this->api->auth->model['pos_id']);
        // $pin->addCondition('under_pos',false);

        // $i=1;
        // foreach($pin as $junk){
            // $pin['adcrd_id']=$to_dist;
            // $pin['under_pos']=0;
            // $pin->saveAndUnload();
        //     $i++;
        //     if($i>$noofpins) break;
        // }
        // throw $this->exception($pin->_dsql()->set('adcrd_id',$to_dist)->set('under_pos',0)->limit($noofpins)->render());//->update();

        $l_from=$this->add('Model_LedgerAll');
        $l_to=$this->add('Model_LedgerAll');

        $l_from->getDistributorLedger($from_dist);
        $l_to->getDistributorLedger($to_dist);

        $this->ref('kit_id')->doSales($noofpins,$l_to->id,$l_from->id,$narration,$on_date);

    }

    function oldPinSalesEntry($from_dist=null,$to_dist,$noofpins=1,$narration,$on_date){
        
        if($from_dist == null) $from_dist = $this['adcrd_id'];

        // $pin=$this->add('Model_Pin');
        // $pin->addCondition('kit_id',$this->ref('kit_id')->id);
        // $pin->addCondition('Used',false);
        // $pin->addCondition('adcrd_id',$from_dist);
        // $pin->addCondition('pos_id',$this->api->auth->model['pos_id']);
        // $pin->addCondition('under_pos',false);

        // if($pin->count()->do_getOne() < $noofpins)
        //     throw $this->exception("There are not sufficient unused pins to transfer");

        // $pin=$this->add('Model_Pin');
        // $pin->addCondition('kit_id',$this->ref('kit_id')->id);
        // $pin->addCondition('Used',false);
        // $pin->addCondition('adcrd_id',$from_dist);
        // $pin->addCondition('pos_id',$this->api->auth->model['pos_id']);
        // $pin->addCondition('under_pos',false);

        // $i=1;
        // foreach($pin as $junk){
            // $pin['adcrd_id']=$to_dist;
            // $pin['under_pos']=0;
            // $pin->saveAndUnload();
        //     $i++;
        //     if($i>$noofpins) break;
        // }
        // throw $this->exception($pin->_dsql()->set('adcrd_id',$to_dist)->set('under_pos',0)->limit($noofpins)->render());//->update();

        $l_from=$this->add('Model_LedgerAll');
        $l_to=$this->add('Model_LedgerAll');

        $l_from->getDistributorLedger($from_dist);
        $l_to->getDistributorLedger($to_dist);

        $this->ref('kit_id')->doSales($noofpins,$l_to->id,$l_from->id,$narration,$on_date);

    }

}