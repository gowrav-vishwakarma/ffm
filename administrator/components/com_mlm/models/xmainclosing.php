<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class xMainClosing extends DataMapper {

    var $table = 'xclosingmain';
    var $has_one = array(
        'distributor' => array(
            'class' => 'distributor',
            'join_other_as' => 'distributor',
            'join_table' => 'jos_xclosingmain',
            'other_field' => 'closings'
        )
    );

    function __construct($id = NULL) {
        parent::__construct($id);
        $q = "UPDATE jos_xtreedetails SET LastClosingCarryAmount = 0";
        $this->db->query($q);
    }

    function confirmUpdateIntroductionIncome($tilldate) {
        $d = new Kit();
        $d->select_sum('AmountToIntroducer', "aa")
                ->where_related_distributors('JoiningDate <', inp('tilldate'))
                ->where_related_distributors('ClosingNewJoining',0)
                ->get();
        return "Total Introduction Amount " . $d->aa . "<br/>";
    }

    function updateIntroductionIncome($tilldate) {
        $this->db->query("UPDATE jos_xtreedetails SET IntroductionINcome=0");
        $IntroducerQuery = "UPDATE jos_xtreedetails as Introducer " .
                "inner join (" .
                "Select SUM(AmountToIntroducer) as TotalIntroAmount, introducer_id from jos_xtreedetails inner join jos_xkitmaster on jos_xtreedetails.kit_id=jos_xkitmaster.id WHERE ClosingNewJoining=0 AND JoiningDate < '$tilldate' GROUP BY introducer_id" .
                ") as Intros on Intros.introducer_id=Introducer.id " .
                "SET Introducer.IntroductionIncome=Intros.TotalIntroAmount ";
        $this->db->query($IntroducerQuery);
        $IntroducerCountUpdate = "UPDATE jos_xtreedetails as Introducer " .
                "inner join (" .
                "Select COUNT(id) as TotalIntros, introducer_id from jos_xtreedetails WHERE JoiningDate < '$tilldate' GROUP BY introducer_id" .
                ") as Intros on Intros.introducer_id=Introducer.id " .
                "SET
                                    Introducer.ClosingIntros=Introducer.ClosingIntros - Intros.TotalIntros
                                    ";
        $this->db->query($IntroducerCountUpdate);
    }

    function updatePVBinaryAndFinalize() {
//                Main Binary Calculation is running in Session Closing .. front end side cco.ac
        $c = new xConfig('closings_config');
        $sessionclosing = $c->getkey('SessionClosing');
        if ($sessionclosing == 0) {
            $SessionClosing = new xSessionClosing();
            $SessionClosing->setSessionBinary();
        }
    }

    function updateRPBinaryAndFinalize() {
        global $com_params;
        $c = new xConfig('binary_income');
        $tailRP = $c->getkey('TailRP');
        $capping = $c->getkey("RPCapping");
        $this->db->query("UPDATE jos_xtreedetails SET temp1=0, ClosingPairRP=0");
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
        $this->db->query($queryA);
        $this->db->query("UPDATE jos_xtreedetails SET ClosingPairRP = temp1, TotalPairRP=TotalPairRP+temp1");
        $this->db->query("UPDATE jos_xtreedetails SET temp1=0");

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
        $this->db->query($queryA);

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

        $this->db->query($queryA);

//        ============== NOW UPDATE ANSESSTORS WITH NEW RP PAIRS PAYABLE IN NEXT CLOSING ====================
//        Actually This is not done here .. its after deducting 20% for upgradation charges, update ansesstors of all updatED ids
    }

    function updateBinaryIncomeFromIntrosShare() {
        $c = new xConfig('binary_income');
        $BinaryShareToIntro = $c->getkey('BinaryShareToIntro');
        $this->db->query("UPDATE jos_xtreedetails SET BinaryIncomeFromIntrosShare=0");
        $q = "UPDATE jos_xtreedetails Introducer
            INNER JOIN jos_xtreedetails Intros on Intros.introducer_id=Introducer.id
            SET Introducer.BinaryIncomeFromIntrosShare = Intros.ClosingPairPV * $BinaryShareToIntro /100.00 ";
        $this->db->query($q);
    }

    function updateRMB($tilldate) {
        global $com_params;
        $PVRate=$com_params->get('PVRate');
        $q = "UPDATE jos_xtreedetails SET RMB=0";
        $this->db->query($q);
//        $q = "UPDATE jos_xtreedetails SET RMB=PV*" . ($com_params->get('PVRate')) . " WHERE DATE_ADD(JoiningDate, '+1 Month') < '$tilldate'";
        $q = "UPDATE jos_xtreedetails t
                INNER JOIN(
                        SELECT
                                id,
                                period_diff(
                                        date_format('$tilldate', '%Y%m'),
                                        date_format(JoiningDate, '%Y%m')
                                )- CASE
                        WHEN date_format('$tilldate', '%d')> date_format(JoiningDate, '%d')THEN
                                0
                        ELSE
                                1
                        END AS M
                FROM
                        jos_xtreedetails
                WHERE
                        JoiningDate < DATE('$tilldate')
                )AS s ON t.id = s.id
                SET t.RMB = t.PV * $PVRate
                WHERE
                        s.M * t.PV * $PVRate > TotalRMB";
        $this->db->query($q);

        $this->db->query("UPDATE jos_xtreedetails SET TotalRMB=TotalRMB+RMB");

//        SELECT period_diff( date_format( '2009-07-15' , '%Y%m' ) , date_format( '2009-05-14', '%Y%m' ) ) - case when date_format( '2009-07-15' , '%d' ) > date_format( '2009-05-14' , '%d' ) then 0 else 1 end;
    }

    function updateLevelIncome($tilldate) {
        global $com_params;
        $c = new xConfig('level_income');
        for ($i = 1; $i <= $c->getkey('LevelsToCount'); $i++) {
            $Level = str_repeat("_", $i);
            $query = "UPDATE
				jos_xtreedetails AS DST
				inner Join
					(SELECT
					`Main`.`id`,
					Count(`Down`.`id`) AS Numbers,
                                        SUM(`Down`.PV) as PVsinLevel,
                                        SUM(`Down`.`RMB`) as RMBSum
					FROM
					`jos_xtreedetails` AS `Main` ,
					( SELECT dt.Path, dt.JoiningDate, dt.id, dt.GreenDate, dt.ClosingNewJoining, dt.PV, dt.RMB FROM `jos_xtreedetails` as dt inner join `jos_xkitmaster` as dk on dk.id=dt.kit_id ) AS `Down`
					WHERE
					`Down`.`Path` LIKE  CONCAT(`Main`.`Path`,'$Level')
					AND `Down`.`JoiningDate` < '$tilldate'
                                        /* AND `Down`.`ClosingNewJoining`=0 */
                                        ";
            if (!$c->getkey('LevelIncomeRedCount'))
                $query .= " AND `Down`.`GreenDate` <> '0000-00-00'";
            $query .=" GROUP BY
					`Main`.`id`) AS
				SRC
				on DST.id=SRC.id
				SET DST.LevelIncome$i = " . ($c->getKey('LevelIncomeBasedOn') == 'DC' ? "SRC.Numbers" : "SRC.RMBSum * ") . $c->getkey('IncomeLevel' . $i);
            $this->db->query($query);
        }
    }

    function updateSurveyIncome() {
        $c = new xConfig("survey_config");
        $PointsNeeded = $c->getkey("SurveyPointsNeededForIncome");
        $SurveyIncome = $c->getkey("SurveyIncome");
        $q = "UPDATE jos_xtreedetails tt
            JOIN
            (SELECT t.id as tid, PointsSummed.PointsEarned
            from jos_xtreedetails t
            INNER JOIN
            (SELECT sd.distributor_id, SUM(s.Points) as PointsEarned FROM
                            jos_xsurvey_done sd
                            INNER JOIN jos_xsurveys s on s.id=sd.survey_id
                            GROUP BY sd.distributor_id
            ) as PointsSummed
            on PointsSummed.distributor_id=t.id
            GROUP BY t.id
            ) as TempT
            on TempT.tid=tt.id
            SET
            tt.SurveyIncome = $SurveyIncome
            WHERE
            TempT.PointsEarned >= $PointsNeeded
            ";
        $this->db->query($q);
        $maxSurvey = $this->db->query("SELECT MAX(ClosingNewSurvey) as maxSurvey FROM jos_xsurveys")->row()->maxSurvey;
        $maxSurvey++;
        $this->db->query("UPDATE jos_xsurveys SET ClosingNewSurvey = $maxSurvey WHERE ClosingNewSurvey=0");
    }

    function updateRoyaltyIncome() {
        $cr = new xConfig("royalty_income");

        $closingDistributors = new Distributor();
        $TotalClosingCount = $closingDistributors->where("ClosingNewJoining", "0")->where("JoiningDate <", inp("tilldate"))->count();

        $r1p = $cr->getkey("Royalty1Pair");
        $r1f = $cr->getkey("Royalty1Fund");
        $r2p = $cr->getkey("Royalty2Pair");
        $r2f = $cr->getkey("Royalty2Fund");
        $r3p = $cr->getkey("Royalty3Pair");
        $r3f = $cr->getkey("Royalty3Fund");

        if ($cr->getkey("Royalty1Pair") > 0) {
            $r_cd = new Distributor();
            $rcdCount = $r_cd->where("TotalPairPV >=", $r1p)->count();
            $q = "UPDATE jos_xtreedetails SET RoyaltyIncome=($TotalClosingCount * $r1f )/ $rcdCount WHERE TotalPairPV >= $r1p";
            $this->db->query($q);
        }
        if ($cr->getkey("Royalty2Pair") > 0) {
            $r_cd = new Distributor();
            $rcdCount = $r_cd->where("TotalPairPV >=", $r2p)->count();
            $q = "UPDATE jos_xtreedetails SET RoyaltyIncome=($TotalClosingCount * $r2f )/ $rcdCount WHERE TotalPairPV >= $r2p";
            $this->db->query($q);
        }
        if ($cr->getkey("Royalty3Pair") > 0) {
            $r_cd = new Distributor();
            $rcdCount = $r_cd->where("TotalPairPV >=", $r3p)->count();
            $q = "UPDATE jos_xtreedetails SET RoyaltyIncome=($TotalClosingCount * $r3f )/ $rcdCount WHERE TotalPairPV >= $r3p";
            $this->db->query($q);
        }
    }

    function calculateTotalIncome($tilldate) {
        global $com_params;
        $this->db->query("UPDATE jos_xtreedetails SET LastClosingCarryAmount=ClosingCarriedAmount");
        
        $q = "UPDATE jos_xtreedetails SET
            ClosingAmount= LastClosingCarryAmount +";
        if ($com_params->get('PlanHasIntroductionIncome')) {
            $q .= " IntroductionIncome +";
        }
        if ($com_params->get('BinarySystem')) {
            $q.="ClosingPairPV +";
        }
        if ($com_params->get('PlanHasLevelIncome')) {
            $c = new xConfig('level_income');
            $q .= " RMB +";
            for ($i = 1; $i <= $c->getkey('LevelsToCount'); $i++) {
                $q .= " LevelIncome$i +";
            }
        }
        if ($com_params->get("RPAsBinary")) {
            $q .="ClosingPairRP +";
        }
        if ($com_params->get('PlanHasSurveyIncome')) {
            $q .="SurveyIncome +";
        }

        if ($com_params->get('PlanHasRoyaltyIncome')) {
            $q .="RoyaltyIncome +";
        }

        $q = trim($q, "+");
        $q .= " WHERE JoiningDate < '$tilldate'";
        $this->db->query($q);


        $q = "UPDATE jos_xtreedetails SET TotalClosingAmount = TotalClosingAmount+ClosingAmount WHERE JoiningDate < '$tilldate'";
        $this->db->query($q);
    }

    function calculateDeductions($tilldate) {
        global $com_params;
        $c = new xConfig('closings_config');

//        ============ PLAN SPECIFIC DEDUCTION ===================
        $this->db->query("UPDATE jos_xtreedetails SET OtherDeductions=0, OtherDeductionRemarks=''");
        $otherDeduction = $c->getkey("OtherDeduction");
        $remarks = $c->getkey("OtherDeductionRemark");
        if ($otherDeduction != '') {
            $q = "UPDATE jos_xtreedetails SET OtherDeductions=ClosingAmount * $otherDeduction";
            $this->db->query($q);
            $q = "UPDATE jos_xtreedetails SET OtherDeductionRemarks = '$remarks' WHERE OtherDEductions > 0";
            $this->db->query($q);
        }


//        ============= SERVICE CHARGE DEDUCTIONS =====================
        $this->db->query("UPDATE jos_xtreedetails SET ClosingServiceCharge = 0");
        $q = "UPDATE jos_xtreedetails SET ClosingServiceCharge = ClosingAmount * " . $c->getkey('ServiceCharges') . " / 100.00 WHERE JoiningDate < '$tilldate'";
        $this->db->query($q);

//        ============== FIrst Payout Deduction =======================
        $firstDeduct = $c->getkey("AmountToDeductFromFirstPayout");
        if ($firstDeduct > 0) {
            $this->db->query("UPDATE jos_xtreedetails SET FirstPayoutDeduction=$firstDeduct");
//		REMOVE 100/- deduction from IDS which are not new ... already setted as deduction from all
            $query = "UPDATE jos_xtreedetails  AS DST
				Right Join
				(SELECT DISTINCT(distributor_id) AS OldDistributor FROM `jos_xclosingmain` WHERE FirstPayoutDeduction > 0 ) AS NotFirst
				on NotFirst.OldDistributor=DST.id
				SET DST.FirstPayoutDeduction=0";
            $this->db->query($query);
        }


//       =============== UPGRADATION DEDUCTION IF ==========================
        if (trim($c->getkey('UpgradationCharges')) != "" or $c->getkey('UpgradationCharges') != 0) {
            $q = "UPDATE jos_xtreedetails SET ClosingUpgradationDeduction=0";
            $this->db->query($q);
            $upgradePercentage = $c->getkey('UpgradationCharges');
            $upgradeLimit = $c->getkey('UpgradationChargesTill');
            $q = "UPDATE jos_xtreedetails t SET t.ClosingUpgradationDeduction = t.ClosingAmount * $upgradePercentage /100.00 WHERE (t.ClosingUpgradationDeduction + t.TotalUpgradationDeduction) < $upgradeLimit ";
            $this->db->query($q);
//            Never going above Upgrade LImit Amount defined in closing_config
            $q = "UPDATE jos_xtreedetails t SET t.ClosingUpgradationDeduction = t.ClosingUpgradationDeduction - ((t.ClosingUpgradationDeduction+t.TotalUpgradationDeduction)-$upgradeLimit) WHERE ((t.ClosingUpgradationDeduction + t.TotalUpgradationDeduction) > $upgradeLimit AND t.TotalUpgradationDeduction < $upgradeLimit)";
            $this->db->query($q);

            $q = "UPDATE jos_xtreedetails t SET t.TotalUpgradationDeduction = t.ClosingUpgradationDeduction + t.TotalUpgradationDeduction";
            $this->db->query($q);

//            =============UPDATE ANSESSTOS OF ALL IDS Which are upgraded in this deduction==========
            if ($c->getkey("UpgradeAnsesstors")) {
                $d = new Distributor();
                $d->where("TotalUpgradationDeduction + ClosingUpgradationDeduction >", $upgradeLimit)
                        ->where("ClosingUpgradationDeduction > ", 0)
                        ->get();

                if ($c->getkey("UpgradePointsWith") == "FixedValue") {
                    $PLUSRP = $c->getkey("FixedUpgradePoints");
                } else {
//                    Values from "{CurrentKitName}_upgrade" kit
                }
                foreach ($d as $dd) {
                    $Path = $dd->Path;
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
                    $this->db->query($q);
                }
            }
        }

//        ============= TDS DEDUCTION =================================
        $this->db->query("UPDATE jos_xtreedetails SET ClosingTDSAmount=0");

        $sq = "0";
        if ($c->getkey('TDSon') == 'AfterAllDeductions') {
            $sq = "t.ClosingServiceCharge + t.OtherDeductions +  t.ClosingUpgradationDeduction";
        }

        $q = "UPDATE jos_xtreedetails t inner join jos_xpersonaldetails p on p.distributor_id=t.id SET t.ClosingTDSAmount = (t.ClosingAmount - ($sq)) * " . ($c->getkey('TDSWithoutPAN')) . "/100.0
            WHERE (p.PanNo='' or p.PanNo is NULL) AND t.JoiningDate < '$tilldate' AND t.TotalClosingAmount >= " . $c->getkey('MinIncomeForTDSDeduction');
        $this->db->query($q);

        $q = "UPDATE jos_xtreedetails t inner join jos_xpersonaldetails p on p.distributor_id=t.id SET t.ClosingTDSAmount = (t.ClosingAmount - ($sq)) * " . ($c->getkey('TDSWithPAN')) . "/ 100.00
            WHERE (p.PanNo<>'' AND p.PanNo is not NULL) AND t.JoiningDate < '$tilldate' AND t.TotalClosingAmount >= " . $c->getkey('MinIncomeForTDSDeduction');
        $this->db->query($q);

        $this->db->query("UPDATE jos_xtreedetails SET TotalTDSAmount=TotalTDSAmount + ClosingTDSAmount");
    }

    function calculateNetAmount($tilldate) {
        $c = new xConfig("closings_config");
        $this->db->query("UPDATE jos_xtreedetails SET ClosingAmountNet=0");
        $upCharge = "0";
        if (trim($c->getkey('UpgradationCharges')) != "" or $c->getkey('UpgradationCharges') != 0) {
            $upCharge = "ClosingUpgradationDeduction";
        }
        $q = "UPDATE jos_xtreedetails SET ClosingAmountNet = ClosingAmount - (ClosingTDSAmount + ClosingServiceCharge + OtherDeductions + $upCharge + FirstPayoutDeduction) WHERE JoiningDate < '$tilldate'";
        $this->db->query($q);
    }

    function setCarryForwardAmount($tilldate) {
        global $com_params;
        $c = new xConfig('closings_config');
        
        $this->db->query("UPDATE jos_xtreedetails SET ClosingCarriedAmount=0");

        $q = "UPDATE jos_xtreedetails SET ClosingCarriedAmount = ClosingAmount, TotalClosingAmount = TotalClosingAmount - ClosingAmount, ClosingTDSAmount=0, ClosingServiceCharge=0, OtherDeductions=0, ClosingAmount=0, ClosingAmountNet=0,TotalUpgradationDeduction=TotalUpgradationDeduction- ClosingUpgradationDeduction, ClosingUpgradationDeduction=0,FirstPayoutDeduction=0 WHERE JoiningDate < '$tilldate' AND (";
        if ($com_params->get('StopPaymentForRedIDs') == 1)
            $q .= " GreenDate = '0000-00-00' OR";
        $q.= " published=0 OR ";

        if ($c->getkey('MinReleasingAmountBasedOn') != 'MinimumCheque')
            $q .= ( " ClosingAmount < " . ($c->getkey('MinReleasingAmount')) );
        else
            $q .= ( " ClosingAmountNet < " . ($c->getkey('MinReleasingAmount')));

        $q .= ")";
        $this->db->query($q);
    }

    function finish($tilldate) {
        global $com_params;
        $maxNewJoining = "SELECT MAX(ClosingNewJoining) as Max FROM jos_xtreedetails";
        $max = $this->db->query($maxNewJoining)->row()->Max;
        $max++;
        $c = new xConfig("closings_config");
        /*
          $query = "UPDATE
          jos_xtreedetails AS DST
          inner Join
          (SELECT
          `Main`.`id` AS id,
          Count(`Down`.`id`) AS Numbers,
          SUM(`Down`.`PV`) AS PV,
          SUM(`Down`.`BV`) AS BV,
          SUM(`Down`.`RP`) AS RP,
          SUM(IF(`Down`.GreenDate='0000-00-00',0,1)) AS GreenCount
          FROM
          `jos_xtreedetails` AS `Main` ,
          (SELECT t.Path,t.JoiningDate, t.ClosingNewJoining, t.id, k.PV, k.BV, k.RP, t.GreenDate FROM `jos_xtreedetails` AS t inner join jos_xkitmaster AS k on t.kit_id=k.id) AS `Down`
          WHERE
          `Down`.`Path` LIKE  CONCAT(`Main`.`Path`,'_%')
          AND `Down`.`JoiningDate` < '$tilldate'
          AND `Down`.`ClosingNewJoining`=0
          GROUP BY
          `Main`.`id`) AS
          SRC
          on DST.id=SRC.id
          SET
          DST.ClosingPV = DST.ClosingPV - SRC.PV,
          DST.ClosingBV = DST.ClosingPV - SRC.BV,
          DST.ClosingRP = DST.ClosingPV - SRC.RP,
          DST.ClosingCount = DST.ClosingCount - SRC.Numbers,
          DST.ClosingGreenCount = DST.ClosingGreenCount - SRC.GreenCount
          ";
          $this->db->query($query);

          //        ============== UPDATE LEGS TABLE =========================
          $query = "
          UPDATE jos_xlegs l
          inner join jos_xtreedetails t on t.sponsor_id=l.distributor_id and t.id=l.downline_id
          SET
          l.ClosingPV = t.ClosingPV,
          l.ClosingBV = t.ClosingBV,
          l.ClosingRP = t.ClosingRP,
          l.ClosingCount = t.ClosingCount,
          l.ClosingGreenCount = t.ClosingGreenCount
          WHERE t.JoiningDate < '$tilldate'
          ";
          $this->db->query($query);
         */

        $q = "UPDATE jos_xtreedetails
                SET
                    ClosingPairPV=0,
                    ClosingBV=0,";
        if (!$com_params->get("RPAsBinary")) {
            $q.="   ClosingPairRP=0,";
        }
        $q.="       ClosingIntros=0,
                    ClosingGreenCount=0,
                    ClosingCount=0

                    ";

        $this->db->query($q);

        $q = "UPDATE jos_xlegs
            SET
                ClosingPV=0,
                ClosingBV=0,";
//        $q .= " ClosingRP=0,";
        $q .= "ClosingIntros=0,
                ClosingGreenCount=0,
                ClosingCount=0
            ";
        $this->db->query($q);

        $query = "UPDATE jos_xtreedetails SET ClosingNewJoining=$max Where ClosingNewJoining=0 AND JoiningDate < '$tilldate'";
        $this->db->query($query);
    }

    function saveclosing($closing, $tilldate) {
//        SAVE IN jos_xbusinessclsongs
        $query = "INSERT INTO jos_xclosingmain " .
                "(" .
                "SELECT
                                    0,
                                    id,
                                    '" .
                $closing
                . "',
                                     LastClosingCarryAmount,
                                     IntroductionIncome,
                                     RMB,
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
        $this->db->query($query);
//        Save a new closing done information so closing beofre this date is not permitted
        
    }

}