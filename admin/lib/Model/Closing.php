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
        $this->addField("BinaryIncomeFromIntrosShare");
        $this->addField("BinaryIncome");
        $this->addField("FutureBinary");
        $this->addField("RoyaltyIncome");
        $this->addField("SurveyIncome");
        $this->addField("ClosingAmount");
        $this->addField("ClosingTDSAmount");
        $this->addField("ClosingServiceCharge");
        $this->addField("OtherDeductions");
        $this->addField("OtherDeductionRemarks");
        $this->addField("ClosingUpgradationDeduction");
        $this->addField("FirstPayoutDeduction");
        $this->addField("ClosingAmountNet");
        $this->addField("ClosingCarriedAmount");
        $this->addField("ChequeNo");
        $this->addField("CuriorNo");
    }

}