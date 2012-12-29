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
        $this->addField("RMB")->caption('Repurchase Income');
        $this->addField("BinaryIncomeFromIntrosShare");
        $this->addField("BinaryIncome");
        $this->addField("FutureBinary");
        $this->addField("RoyaltyIncome");
        $this->addField("SurveyIncome");
        $this->addField("ClosingAmount");
        $this->addField("ClosingTDSAmount");
        $this->addField("ClosingServiceCharge");
        $this->addField("OtherDeductions")->caption('Social Deduction');
        $this->addField("OtherDeductionRemarks");
        $this->addField("ClosingUpgradationDeduction");
        $this->addField("FirstPayoutDeduction");
        $this->addField("ClosingAmountNet");
        $this->addField("ClosingCarriedAmount");
        $this->addField("ChequeNo");
        $this->addField("CuriorNo");
    
        $this->addExpression("name")->set('Closing');
    }
    
    function updatePVBinaryAndFinalize(){
        
    }
    
    function updateRPBinaryAndFinalize(){
        //global $com_params;
        //$c = new xConfig('binary_income');
        $tailRP = 0;//$c->getkey('TailRP');
        $capping = 50000;//$c->getkey("RPCapping");
        $this->query("UPDATE jos_xtreedetails SET temp1=0, ClosingPairRP=0");
        $queryA = "UPDATE jos_xtreedetails
                    LEFT OUTER JOIN jos_xlegs AS `left` ON jos_xtreedetails.id = `left`.distributor_id
                    LEFT OUTER JOIN jos_xlegs AS `right` ON jos_xtreedetails.id = `right`.distributor_id
				SET
				jos_xtreedetails.temp1=IF(`left`.ClosingRP <> `right`.ClosingRP,
					/*      TRUE PORTION  */
						IF(  IF ( `left`.ClosingRP  < `right`.ClosingRP, `left`.ClosingRP, `right`.ClosingRP) < $capping,
							 IF ( `left`.ClosingRP  < `right`.ClosingRP, `left`.ClosingRP, `right`.ClosingRP), /* True*/
							$capping /*False*/
						),
					/*      FALSE PORTION       */
						IF(  IF ( `left`.ClosingRP-$tailRP  < `right`.ClosingRP-$tailRP, `left`.ClosingRP-$tailRP, `right`.ClosingRP-$tailRP) < $capping,
							 IF ( `left`.ClosingRP-$tailRP  < `right`.ClosingRP-$tailRP, `left`.ClosingRP-$tailRP, `right`.ClosingRP-$tailRP), /* True */
							$capping /* False */
						)
					)
				WHERE
				`left`.ClosingRP <>0 AND `right`.ClosingRP<>0
                                AND
                                `left`.Leg = 'A' AND
                                `right`.Leg = 'B'";
        $this->query($queryA);
        $this->query("UPDATE jos_xtreedetails SET ClosingPairRP = temp1, TotalPairRP=TotalPairRP+temp1");
        $this->query("UPDATE jos_xtreedetails SET temp1=0");

        $queryA = "UPDATE jos_xtreedetails
                    LEFT OUTER JOIN jos_xlegs AS `left` ON jos_xtreedetails.id = `left`.distributor_id
                    LEFT OUTER JOIN jos_xlegs AS `right` ON jos_xtreedetails.id = `right`.distributor_id
				SET
				jos_xtreedetails.temp1=IF(`left`.ClosingRP <> `right`.ClosingRP,
                                                        IF( `left`.ClosingRP < `right`.ClosingRP , `left`.ClosingRP, `right`.ClosingRP),
                                        /*	 else 		*/
                                                        `left`.ClosingRP-$tailRP
                                        )
				WHERE
				`left`.ClosingRP <> 0 AND `right`.ClosingRP<> 0
                                AND
                                `left`.Leg = 'A' AND
                                `right`.Leg = 'B'";
        $this->query($queryA);

        $queryA = "UPDATE jos_xtreedetails
                    LEFT OUTER JOIN jos_xlegs AS `left` ON jos_xtreedetails.id = `left`.distributor_id
                    LEFT OUTER JOIN jos_xlegs AS `right` ON jos_xtreedetails.id = `right`.distributor_id
				SET
				`left`.ClosingRP=`left`.ClosingRP - jos_xtreedetails.temp1,
                                `right`.ClosingRP=`right`.ClosingRP - jos_xtreedetails.temp1
				WHERE
				`left`.ClosingRP <> 0 AND `right`.ClosingRP<> 0
                                AND
                                `left`.Leg = 'A' AND
                                `right`.Leg = 'B'";

        $this->query($queryA);

//        ============== NOW UPDATE ANSESSTORS WITH NEW RP PAIRS PAYABLE IN NEXT CLOSING ====================
//        Actually This is not done here .. its after deducting 20% for upgradation charges, update ansesstors of all updatED ids
    }
    
    function  updateRoyaltyIncome($closing_date){
        throw $this->exception("Royalty called");
//        $cr = new xConfig("royalty_income");
//
//        $closingDistributors = $this->add('Model_Distributor');
//        $TotalClosingCount = $closingDistributors
//                                ->addCondition("ClosingNewJoining", "0")    
//                                ->addCondition("JoiningDate <", $closing_date)
//                                ->count()->getOne();
//
//        $r1p = $cr->getkey("Royalty1Pair");
//        $r1f = $cr->getkey("Royalty1Fund");
//        $r2p = $cr->getkey("Royalty2Pair");
//        $r2f = $cr->getkey("Royalty2Fund");
//        $r3p = $cr->getkey("Royalty3Pair");
//        $r3f = $cr->getkey("Royalty3Fund");
//
//        if ($cr->getkey("Royalty1Pair") > 0) {
//            $r_cd = new Distributor();
//            $rcdCount = $r_cd->where("TotalPairPV >=", $r1p)->count();
//            $q = "UPDATE jos_xtreedetails SET RoyaltyIncome=($TotalClosingCount * $r1f )/ $rcdCount WHERE TotalPairPV >= $r1p";
//            $this->query($q);
//        }
//        if ($cr->getkey("Royalty2Pair") > 0) {
//            $r_cd = new Distributor();
//            $rcdCount = $r_cd->where("TotalPairPV >=", $r2p)->count();
//            $q = "UPDATE jos_xtreedetails SET RoyaltyIncome=($TotalClosingCount * $r2f )/ $rcdCount WHERE TotalPairPV >= $r2p";
//            $this->query($q);
//        }
//        if ($cr->getkey("Royalty3Pair") > 0) {
//            $r_cd = new Distributor();
//            $rcdCount = $r_cd->where("TotalPairPV >=", $r3p)->count();
//            $q = "UPDATE jos_xtreedetails SET RoyaltyIncome=($TotalClosingCount * $r3f )/ $rcdCount WHERE TotalPairPV >= $r3p";
//            $this->query($q);
//        }
    }
    
    function updateRepurchaseIncome($closing_name){
        // actually nothing to do in calculations but making Closing BV zero
        $this->query("UPDATE jos_xtreedetails SET ClosingBV=0");
        $this->memorize('repurchase_closing','ClosingBV');
    }
    
    function calculateTotalIncome($closing_name){
//        global $com_params;
        $this->query("UPDATE jos_xtreedetails SET LastClosingCarryAmount=ClosingCarriedAmount");
        
        $q = "UPDATE jos_xtreedetails SET
            ClosingAmount= LastClosingCarryAmount +";
       
        if (true /*$com_params->get('BinarySystem')*/) {
            $q.="ClosingPairPV +";
        }
        
        if (true /*$com_params->get("RPAsBinary")*/) {
            $q .="ClosingPairRP +";
        }
        
        if($this->recall('$ClosingBvField',false) !== false){
            $q .="ClosingBV +";
        }

//        if ($com_params->get('PlanHasRoyaltyIncome')) {
//            $q .="RoyaltyIncome +";
//        }

        $q = trim($q, "+");
        $q .= " WHERE JoiningDate < '$closing_name'";
        $this->query($q);


        $q = "UPDATE jos_xtreedetails SET TotalClosingAmount = TotalClosingAmount+ClosingAmount WHERE JoiningDate < '$closing_name'";
        $this->query($q);
    }
    
    function calculateDeductions($tilldate){
       
//        $c = new xConfig('closings_config');

//        ============ PLAN SPECIFIC DEDUCTION ===================
        $this->query("UPDATE jos_xtreedetails SET OtherDeductions=0, OtherDeductionRemarks=''");
        $otherDeduction = 1/100;//$c->getkey("OtherDeduction");
        $remarks ="Social Welfare Fund";// $c->getkey("OtherDeductionRemark");
        if ($otherDeduction != '') {
            $q = "UPDATE jos_xtreedetails SET OtherDeductions=ClosingAmount * $otherDeduction";
            $this->query($q);
            $q = "UPDATE jos_xtreedetails SET OtherDeductionRemarks = '$remarks' WHERE OtherDEductions > 0";
            $this->query($q);
        }


//        ============= SERVICE CHARGE DEDUCTIONS =====================
        $this->query("UPDATE jos_xtreedetails SET ClosingServiceCharge = 0");
        $q = "UPDATE jos_xtreedetails SET ClosingServiceCharge = ClosingAmount * 5 / 100.00 WHERE JoiningDate < '$tilldate'";
        $this->query($q);

//        ============== FIrst Payout Deduction =======================
        $firstDeduct = 100;//$c->getkey("AmountToDeductFromFirstPayout");
        if ($firstDeduct > 0) {
            $this->query("UPDATE jos_xtreedetails SET FirstPayoutDeduction=$firstDeduct");
//		REMOVE 100/- deduction from IDS which are not new ... already setted as deduction from all
            $query = "UPDATE jos_xtreedetails  AS DST
				Right Join
				(SELECT DISTINCT(distributor_id) AS OldDistributor FROM `jos_xclosingmain` WHERE FirstPayoutDeduction > 0 ) AS NotFirst
				on NotFirst.OldDistributor=DST.id
				SET DST.FirstPayoutDeduction=0";
            $this->query($query);
        }


//       =============== UPGRADATION DEDUCTION IF ==========================
        if (true /*trim($c->getkey('UpgradationCharges')) != "" or $c->getkey('UpgradationCharges') != 0*/) {
            $q = "UPDATE jos_xtreedetails SET ClosingUpgradationDeduction=0";
            $this->query($q);
            $upgradePercentage = 20;//$c->getkey('UpgradationCharges');
            $upgradeLimit = 8000;//$c->getkey('UpgradationChargesTill');
            $q = "UPDATE jos_xtreedetails t SET t.ClosingUpgradationDeduction = t.ClosingAmount * $upgradePercentage /100.00 WHERE (t.ClosingUpgradationDeduction + t.TotalUpgradationDeduction) < $upgradeLimit ";
            $this->query($q);
//            Never going above Upgrade LImit Amount defined in closing_config
            $q = "UPDATE jos_xtreedetails t SET t.ClosingUpgradationDeduction = t.ClosingUpgradationDeduction - ((t.ClosingUpgradationDeduction+t.TotalUpgradationDeduction)-$upgradeLimit) WHERE ((t.ClosingUpgradationDeduction + t.TotalUpgradationDeduction) > $upgradeLimit AND t.TotalUpgradationDeduction < $upgradeLimit)";
            $this->query($q);

            $q = "UPDATE jos_xtreedetails t SET t.TotalUpgradationDeduction = t.ClosingUpgradationDeduction + t.TotalUpgradationDeduction";
            $this->query($q);

//            =============UPDATE ANSESSTOS OF ALL IDS Which are upgraded in this deduction==========
            if (true /*$c->getkey("UpgradeAnsesstors")*/) {
                $d =$this->add('Model_Distributor');
                $d->addCondition("ClosingUpgradationDeduction"," > ", 0);
                $d->_dsql()->where($d->dsql()->expr("TotalUpgradationDeduction + ClosingUpgradationDeduction"),">", $upgradeLimit);
//                $d->debug();
                if (true /*$c->getkey("UpgradePointsWith") == "FixedValue"*/) {
                    $PLUSRP = 1000;//$c->getkey("FixedUpgradePoints");
                } else {
//                    Values from "{CurrentKitName}_upgrade" kit
                }
                foreach ($d as $dd) {
                    $Path = $dd['Path'];
                    $q = "UPDATE jos_xlegs l
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
                        l.ClosingRP = l.ClosingRP+$PLUSRP";
                    $this->query($q);
                }
            }
        }

//        ============= TDS DEDUCTION =================================
        $this->query("UPDATE jos_xtreedetails SET ClosingTDSAmount=0");

        $sq = "0";
        if (false /*$c->getkey('TDSon') == 'AfterAllDeductions'*/) {
            $sq = "t.ClosingServiceCharge + t.OtherDeductions +  t.ClosingUpgradationDeduction";
        }

        $q = "UPDATE jos_xtreedetails t inner join jos_xpersonaldetails p on p.distributor_id=t.id SET t.ClosingTDSAmount = (t.ClosingAmount - ($sq)) * " . (20 /*$c->getkey('TDSWithoutPAN')*/) . "/100.0
            WHERE (p.PanNo='' or p.PanNo is NULL) AND t.JoiningDate < '$tilldate' AND t.TotalClosingAmount >= " . 0;
        $this->query($q);

        $q = "UPDATE jos_xtreedetails t inner join jos_xpersonaldetails p on p.distributor_id=t.id SET t.ClosingTDSAmount = (t.ClosingAmount - ($sq)) * " . (10) . "/ 100.00
            WHERE (p.PanNo<>'' AND p.PanNo is not NULL) AND t.JoiningDate < '$tilldate' AND t.TotalClosingAmount >= " . 0;
        $this->query($q);

        $this->query("UPDATE jos_xtreedetails SET TotalTDSAmount=TotalTDSAmount + ClosingTDSAmount");
    }
        
    
    
    function calculateNetAmount($closing_name){
        
//        $c = new xConfig("closings_config");
        $this->query("UPDATE jos_xtreedetails SET ClosingAmountNet=0");
        $upCharge = "0";
        if (true /*$c->getkey('UpgradationCharges')) != "" or $c->getkey('UpgradationCharges') != 0*/) {
            $upCharge = "ClosingUpgradationDeduction";
        }
        $q = "UPDATE jos_xtreedetails SET ClosingAmountNet = ClosingAmount - (ClosingTDSAmount + ClosingServiceCharge + OtherDeductions + $upCharge + FirstPayoutDeduction) WHERE JoiningDate < '$closing_name'";
        $this->query($q);
        
    }
    
    function setCarryForwardAmount($closing_name){
        
//      global $com_params;
//        $c = new xConfig('closings_config');
        
        $this->query("UPDATE jos_xtreedetails SET ClosingCarriedAmount=0");

        $q = "UPDATE jos_xtreedetails SET ClosingCarriedAmount = ClosingAmount, TotalClosingAmount = TotalClosingAmount - ClosingAmount, ClosingTDSAmount=0, ClosingServiceCharge=0, OtherDeductions=0, ClosingAmount=0, ClosingAmountNet=0,TotalUpgradationDeduction=TotalUpgradationDeduction- ClosingUpgradationDeduction, ClosingUpgradationDeduction=0,FirstPayoutDeduction=0 WHERE JoiningDate < '$closing_name' AND (";
        if (false /*$com_params->get('StopPaymentForRedIDs') == 1*/)
            $q .= " GreenDate = '0000-00-00' OR";
        $q.= " published=0 OR ";

        if (false/*$c->getkey('MinReleasingAmountBasedOn') != 'MinimumCheque'*/)
            $q .= ( " ClosingAmount < " . ($c->getkey('MinReleasingAmount')) );
        else
            $q .= ( " ClosingAmountNet < " . (500));

        $q .= ")";
        $this->query($q);
    }

    function finish($tilldate) {
//        global $com_params;
        
        $maxNewJoining=$this->add('Model_Distributor');
        $max=$maxNewJoining->_dsql()->del('field')->field($maxNewJoining->dsql()->expr('MAX(ClosingNewJoining)'))->getOne();
//        $maxNewJoining = "SELECT MAX(ClosingNewJoining) as Max FROM jos_xtreedetails";
//        $max = $this->db->query($maxNewJoining)->row()->Max;
        $max++;
//        $c = new xConfig("closings_config");
       

        $q = "UPDATE jos_xtreedetails
                SET
                    ClosingPairPV=0,
                    "; //ClosingBV is maintained in repurchase income to be zero
        if (!true) {
            $q.="   ClosingPairRP=0,";
        }
        $q.="       ClosingIntros=0,
                    ClosingGreenCount=0,
                    ClosingCount=0

                    ";

        $this->query($q);

        $q = "UPDATE jos_xlegs
            SET
                ClosingPV=0,
                "; //ClosingBV is maintained in repurchase income to be zero
//        $q .= " ClosingRP=0,";
        $q .= "ClosingIntros=0,
                ClosingGreenCount=0,
                ClosingCount=0
            ";
        $this->query($q);

        $query = "UPDATE jos_xtreedetails SET ClosingNewJoining=$max Where ClosingNewJoining=0 AND JoiningDate < '$tilldate'";
        $this->query($query);
    }

    function saveclosing($closing) {
//        SAVE IN jos_xbusinessclsongs
        $ClosingBvField=$this->recall('repurchase_closing','0');

        $query = "INSERT INTO jos_xclosingmain " .
                "(" .
                "SELECT
                                    0,
                                    id,
                                    '" . $closing. "',
                                     LastClosingCarryAmount,
                                     IntroductionIncome,
                                     $ClosingBvField, /* Going in RMB Field if repurchase is closing*/
                                     BinaryIncomeFromIntrosShare,
                                     LevelIncome1,
                                     LevelIncome2,
                                     LevelIncome3,
                                     LevelIncome4,
                                     LevelIncome5,
                                     LevelIncome6,
                                     LevelIncome7,
                                     LevelIncome8,
                                     LevelIncome9,
                                     LevelIncome10,
                                     ClosingPairPV,
                                     ClosingPairRP,
                                     RoyaltyIncome,
                                     SurveyIncome,
                                     ClosingAmount,
                                     ClosingTDSAmount,
                                     ClosingServiceCharge,
                                     OtherDeductions,
                                     OtherDeductionRemarks,
                                     ClosingUpgradationDeduction,
                                     FirstPayoutDeduction,
                                     ClosingAmountNet,
                                     ClosingCarriedAmount,
                                     0,
                                     0
				FROM
                                    `jos_xtreedetails` t" .
                ")";
        $this->query($query);
//        Save a new closing done information so closing beofre this date is not permitted
        
    }
    
    
    function createCommissionVouchers($closing_name){
        $clossings=$this->add('Model_Closing');
        $clossings->addCondition('ClosingAmountNet','>',0);
        $clossings->addCondition('closing',$closing_name);
        
        // throw $this->exception($_GET['closing_page']);
        $comm=$this->add('Model_CommissionVoucher');
        $vn=1;
        foreach($clossings as $c){
            $on_date=date("Y-m-d",strtotime(str_replace("_", "-", $c['closing'])));
            $dr_accounts=array(
                    7 => array("Amount"=>$c['ClosingTDSAmount']),
                    8 => array("Amount"=>$c['ClosingAmountNet']),
                    23 => array("Amount"=>$c['ClosingServiceCharge']),
                    24 => array('Amount' => $c['OtherDeductions']),
                    25 => array('Amount'=>$c['FirstPayoutDeduction']),
                    26 => array('Amount'=>$c['ClosingUpgradationDeduction'])
                );

            $l_from=$this->add('Model_LedgerAll');
            $l_from->getDistributorLedger($c['distributor_id']);
            
            $cr_accounts=array(
                    $l_from->id => array("Amount"=>$c['ClosingAmount'])
                );


            $comm->addVoucher($dr_accounts, $cr_accounts, $vn++,false,$c['distributor_id'],null,$on_date);
            $l_from->destroy();
        }
        $this->query("UPDATE jos_xxvouchers SET pos_id=1");
        
    }

    function query($q){
        $this->api->db->dsql()->expr($q)->execute();
    }
    
    
    
}