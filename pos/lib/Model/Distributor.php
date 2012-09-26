<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Distributor extends Model_Table{
    var $table='jos_xtreedetails';
    
    function init() {
        parent::init();
        $this->hasOne("Distributor", "sponsor_id");
        
        $details = $this->join('jos_xpersonaldetails.distributor_id');

        $details->addField('fullname', 'Name')->mandatory("Name is must to give");
        $details->addField('Father_HusbandName')->caption('Father/Husband Name');
        $details->addField('Password')->type('password'); //->system(true);
        $details->addField('Dob')->type('date');
        $details->addField('Address')->type('text');
        $details->addField('City');
        $details->addField('District');
        $details->addField('State');
        $details->addField('Country');
        $details->addField('MobileNo');
        $details->addField('Nominee');
        $details->addField('RelationWithNominee');
        
        $this->hasMany("SponsoredDistributors", "sponsor_id");
        $this->hasMany("Details", "distributor_id");
        $this->hasMany("Closing","distributor_id");
        $this->hasMany("Session","distributor_id");
        $this->hasMany("Leg","distributor_id");
        $this->hasMany("LegEntry","downline_id");
        
        $this->addExpression('name')->set($this->dsql()->expr('concat(distributor_id," - ", Name )'));
        
    }
}