<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Distributor extends Model_Table {

    var $table='jos_xtreedetails';
    
    function init() {

        parent::init();

        $this->hasOne("Distributor", "sponsor_id")->display(array('form'=>'autocomplete/basic'));
        $this->hasOne("Kit", "kit_id");
        $this->hasOne("Pin", "pin_id")->system(true)->display(array('form'=>'autocomplete/basic'));
        
        $details=$this->join('jos_xpersonaldetails.distributor_id');

        $details->addField('fullname', 'Name')->mandatory("Name is must to give");
        $details->addField('Father_HusbandName')->caption('Father/Husband Name');
        $details->addField('Password')->type('password'); //->system(true);
        $details->addField('Dob')->type('date');
        $details->addField('Address')->type('text');
        $details->addField('District');
        $details->addField('City');
        $details->addField('PanNo');
        $details->addField('State');
        $details->addField('Gender')->type('radio')->setValueList(array("M"=>"Male","F"=>"Female"));
        $details->addField('Country');
        $details->addField('Nominee');
        $details->addField('RelationWithNominee','RelainWithNominee');
        $details->addField('MobileNo');
        $details->addField('Bank');
        $details->addField('IFSC')->caption("IFSC Code");
        $details->addField('AccountNumber');
        $details->addField('PinManagerPassword')->type('password');

        $this->addField('JoiningDate')->type('date')->defaultValue(date('Y-m-d'));

        $this->hasMany("SponsoredDistributors", "sponsor_id");
        $this->hasMany("Details", "distributor_id");
        $this->hasMany("Closing","distributor_id");
        $this->hasMany("Session","distributor_id");
        $this->hasMany("Leg","distributor_id");
        $this->hasMany("LegEntry","downline_id");
        $this->hasMany("MillionRewards","distributor_id");
        $this->hasMany("BillionRewards","distributor_id");

        $this->hasMany("Pin","adcrd_id");
        $this->hasMany("UsedPins","adcrd_id");

        $this->addField('Path')->system(true);

        
        $this->addExpression('name')->set('concat(distributor_id," - ", Name )');
        $this->addExpression('left_id')->set(function($m,$q){
            return $m->refSQL('Leg')->addCondition('Leg','A')->dsql()->field('downline_id');
        });
        $this->addExpression('right_id')->set(function($m,$q){
            return $m->refSQL('Leg')->addCondition('Leg','B')->dsql()->field('downline_id');
        });
        $this->addExpression('inLeg')->set('RIGHT(Path,1)');
        
        $this->addHook('beforeSave',$this);
    }

    function beforeSave(){

        


        throw $this->exception("You are not allowed to add any distributor at this stage");
    }

}