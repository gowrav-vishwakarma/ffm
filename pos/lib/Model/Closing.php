<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Closing extends Model_Table {

    var $table = 'jos_xclosingmain';

    function init() {
        parent::init();
        $this->hasOne("Distributor", "distributor_id");

        $this->addField("closing");
        $this->addField("LastClosingCarryAmount");
        $this->addField("IntroductionAmount");
        $this->addField("RMB");
    }

}