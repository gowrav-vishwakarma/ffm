<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Kit extends Model_Table {

    var $table = 'jos_xkitmaster';

    function init() {
        parent::init();
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


}