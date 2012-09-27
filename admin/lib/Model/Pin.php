<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Pin extends Model_Table {

    var $table = 'jos_xpinmaster';

    function init() {
        parent::init();
        $this->hasOne('Distributor','adcrd_id');
        $this->hasOne('Kit','kit_id');
        $this->addField('BV');
        $this->addField('PV');
        $this->addField('RP');

        $this->addField('Pin');

        $this->addField('Used')->type('boolean')->defaultValue(false);
        $this->addField('published')->type('boolean')->defaultValue(false);
        $this->addField('created_at')->type('date')->defaultValue(date('Y-m-d'))->system(true);
        $this->addField('updated_at')->type('date')->defaultValue(date('Y-m-d'))->system(true);

        $this->addExpression('distributor_id')->set('id');

    }

    function generateAndSave($kit_id,$bv,$pv,$rp,$adcrd_id){
    	
    	$this['kit_id']=$kit_id;
    	$this['BV']=$bv;
    	$this['PV']=$pv;
    	$this['RP']=$rp;
    	$this['adcrd_id']=$adcrd_id;


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

}