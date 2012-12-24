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

        $this->addField('PV');
        $this->addField('BV');
        $this->addField('RP');
        
        $details=$this->join('jos_xpersonaldetails.distributor_id');

        $details->addField('fullname', 'Name')->mandatory("Name is must to give");
        $details->addField('Father_HusbandName')->caption('Father/Husband Name');
        $details->addField('Password')->display(array("form"=>"password")); //->system(true);
        $details->addField('Dob')->type('date');
        $details->addField('Address')->type('text');
        $details->addField('District');
        $details->addField('City');
        $details->addField('PanNo');
        $details->addField('State');
        $details->addField('Gender')->type('radio')->display(array("grid"=>"text"))->setValueList(array("M"=>"Male","F"=>"Female"));
        $details->addField('Country');
        $details->addField('Nominee');
        $details->addField('RelationWithNominee','RelainWithNominee');
        $details->addField('MobileNo');
        $details->addField('Bank');
        $details->addField('IFSC')->caption("IFSC Code");
        $details->addField('AccountNumber');
        $details->addField('PinManagerPassword')->display(array("form"=>"password"));

        $this->addField('JoiningDate')->type('date')->defaultValue(date('Y-m-d'));
        $this->addField('Path')->system(true);
        $this->addField('TotalUpgradationDeduction')->system(true);
        $this->addField('ClosingUpgradationDeduction')->system(true);
        $this->addField('ClosingBV')->system(true);

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

        $this->hasMany("LedgerAll","distributor_id");

        
        $this->addExpression('name')->set('concat(distributor_id," - ", Name )');
        $this->addExpression('left_id')->set(function($m,$q){
            return $m->refSQL('Leg')->addCondition('Leg','A')->dsql()->field('downline_id');
        });
        $this->addExpression('right_id')->set(function($m,$q){
            return $m->refSQL('Leg')->addCondition('Leg','B')->dsql()->field('downline_id');
        });
        $this->addExpression('inLeg')->set('RIGHT(Path,1)');
        
        $this->addHook('beforeSave',$this);
        $this->addHook('afterSave',$this);
    }

    function beforeSave(){

        if(!$this->loaded()){
            $this->recall('new_entry',false);
            $sponsor=$this->add('Model_Distributor');
            $sponsor->load($this['sponsor_id']);

            $this['Path']=$sponsor['Path']. $this->recall('leg');

            $leg=$this->add('Model_Leg');
            $leg['distributor_id']=$sponsor->id;
            $leg['Leg']=$this->recall('leg');
            $leg['downline_id']=$this['id'];
            $leg->save();
            
            $pin=$this->ref('pin_id');
            $pin['Used']=true;
            $pin->save();

            $kit=$pin->ref('kit_id');

            $this['kit_id']   = $pin['kit_id'];
            $this['adcrd_id'] = $pin['adcrd_id'];
            $this['PV']       = $pin['PV'];
            $this['BV']       = $pin['BV'];
            $this['RP']       = $pin['RP'];
            
            $this['GreenDate']= ($kit['DefaultGreen']==1 ? date('Y-m-d'): "0000-00-00");

            $mr=$this->add('Model_MillionRewards');
            $mr['distributor_id']=$this['id'];
            $mr->save();

            $br=$this->add('Model_BillionRewards');
            $br['distributor_id']=$this['id'];
            $br->save();

        }

        // throw $this->exception("You are not allowed to add any distributor at this stage");
    }

    function afterSave(){
        if($this->recall('new_entry',false)){
            $this->forget('new_entry');
                $this->createLedger();
                $this->updateAnsesstors();
                $this->joiningVoucherEntry();
        }
    }

    function createLedger(){
        $l=$this->add('Model_LedgerAll');
        $l['name']=$this['name'];
        $l['distributor_id'] = $this->id;
        $l['group_id']= $this->add('Model_GroupsAll')->getGroupID('Branches And Divisions');
        $l['default_account']=true;
        $l->save();
        $this->memorize('ledger_id',$l->id);

    }

    function updateAnsesstors($PV=null,$BV=null,$RP=null){
        $Path = $this['Path'];
        $kit = $this->ref('kit_id');
        $PV = ($PV == null ) ? $kit['PV'] : $PV;
        $BV = ($BV == null ) ? $kit['BV'] : $BV;
        $RP = ($RP == null ) ? $kit['RP'] : $RP;
        // $IntroAmount = $kit['AmountToIntroducer'];
        $Green = $kit['DefaultGreen'];


        $query = "
                UPDATE jos_xlegs l
                        inner join
                        (
                                SELECT
                                                        jos_xtreedetails.id AS id,
                                                        jos_xlegs.Leg AS Leg,
                                                        LEFT('$Path',LENGTH(path)) AS desired ,
                                                        path,
                                                        MID('$Path',LENGTH(path)+1,1) AS nextChar
                                                FROM
                                                        jos_xlegs
                                                INNER JOIN
                                                        jos_xtreedetails on jos_xtreedetails.id=jos_xlegs.distributor_id
                                                HAVING
                                                        desired=path and
                                                        jos_xlegs.Leg=nextChar
                        ) as Ansesstors
                        on Ansesstors.id=l.distributor_id and Ansesstors.Leg=l.Leg
                        inner join jos_xtreedetails t
                            on Ansesstors.id=t.id
                        SET
                        l.SessionPV = l.SessionPV+$PV,
                        l.MidSessionPV = l.MidSessionPV + $PV,
                        l.ClosingPV = l.ClosingPV + $PV,

                        l.SessionBV = l.SessionBV+$BV,
                        l.MidSessionBV = l.MidSessionBV + $BV,
                        l.ClosingBV = l.ClosingBV + $BV,

                        l.SessionRP = l.SessionRP+$RP,
                        l.MidSessionRP = l.MidSessionRP + $RP,
                        l.ClosingRP = l.ClosingRP + $RP,

                        l.SessionGreenCount = l.SessionGreenCount + $Green,
                        l.MidSessionGreenCount = l.MidSessionGreenCount + $Green,
                        l.ClosingGreenCount = l.ClosingGreenCount + $Green,
                        l.TotalGreenCount = l.TotalGreenCount + $Green,

                        l.SessionCount = l.SessionCount + 1,
                        l.MidSessionCount = l.MidSessionCount+1,
                        l.ClosingCount = l.ClosingCount + 1,
                        l.TotalCount = l.TotalCount + 1,

                        /*
                        t.SessionPV = t.SessionPV+$PV,
                        t.MidSessionPV = t.MidSessionPV + $PV,
                        t.ClosingPV = t.ClosingPV + $PV,

                        t.SessionBV = t.SessionBV+$BV,
                        t.MidSessionBV = t.MidSessionBV + $BV,
                        t.ClosingBV = t.ClosingBV + $BV,

                        t.SessionRP = t.SessionRP+$RP,
                        t.MidSessionRP = t.MidSessionRP + $RP,
                        t.ClosingRP = t.ClosingRP + $RP,

                        t.TotalPV = t.TotalPV + $PV,
                        t.TotalBV = t.TotalBV + $BV,
                        t.TotalRP = t.TotalRP + $RP,*/

                        t.SessionGreenCount = t.SessionGreenCount + $Green,
                        t.MidSessionGreenCount = t.MidSessionGreenCount + $Green,
                        t.ClosingGreenCount = t.ClosingGreenCount + $Green,
                        t.TotalGreenCount = t.TotalGreenCount + $Green,

                        t.SessionCount = t.SessionCount + 1,
                        t.MidSessionCount = t.MidSessionCount+1,
                        t.ClosingCount = t.ClosingCount + 1,
                        t.TotalCount = t.TotalCount + 1
                ";

        $this->api->db->dsql()->expr($query)->execute();
    }

    function joiningVoucherEntry(){
        if($this->ref('pin_id')->get('under_pos')){
            // PIN WAS PURCHASED FROM POS
            $this->ref('pin_id')->singleSaleToDIST($this->id,"Joining of " . $this->id);
            
        }else{
            // PIN WAS PURCHASED FROM ANOTHER DISTRIBUTOR
            $this->ref('pin_id')->saleFromDistToDist(null,$this->id,1,"Joining of ". $this->id);
        }
    }

}