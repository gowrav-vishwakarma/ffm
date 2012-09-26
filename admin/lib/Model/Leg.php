<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Leg extends Model_Table {

    var $table = 'jos_xlegs';

    function init() {
        parent::init();
        $this->hasOne("Distributor",'distributor_id');
        $this->hasOne("Distributor",'downline_id');
        $this->addField('Leg');
        $this->addField('SessionPV');
        $this->addField('MidSessionPV');
        $this->addField('ClosingPV');
        $this->addField('SessionBV');
        $this->addField('MidSessionBV');
        $this->addField('ClosingBV');
        $this->addField('SessionRP');
        $this->addField('MidSessionRP');
        $this->addField('ClosingRP');
        $this->addField('SessionIntros');
        $this->addField('MidSessionIntros');
        $this->addField('ClosingIntros');
        $this->addField('SessionGreenCount');
        $this->addField('MidSessionGreenCount');
        $this->addField('ClosingGreenCount');
        $this->addField('TotalGreenCount');
        $this->addField('SessionCount');
        $this->addField('MidSessionCount');
        $this->addField('ClosingCount');
        $this->addField('TotalCount');

    }

}