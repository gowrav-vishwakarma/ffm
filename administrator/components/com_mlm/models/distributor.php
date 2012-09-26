<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Distributor extends DataMapper {

    var $table = "xtreedetails";
    var $created_field = 'JoiningDate';
    var $has_one = array(
        "kit" => array(
            "class" => "kit",
            "join_other_as" => "kit",
            "other_field" => "distributors",
            "join_table" => "jos_xtreedetails"
        ),
        "pin" => array(
            "class" => "pin",
            "join_other_as" => "pin",
            "other_field" => "distributor",
            "join_table" => "jos_xtreedetails"
        ),
        "sponsor" => array(
            "class" => "distributor",
            "join_other_as" => "sponsor",
            "other_field" => "sponsorof",
            "join_table" => "jos_xtreedetails"
        ),
        "introducer" => array(
            "class" => "distributor",
            "join_other_as" => "introducer",
            "other_field" => "intrducerof",
            "join_table" => "jos_xtreedetails"
        ),
        "detail" => array(
            "class" => "details",
            "join_self_as" => "distributor",
            "other_field" => "detailsof",
            "join_table" => "jos_xpersonaldetails"
        ),
        'rewards'=>array(
            'class'=>'rewards',
            'join_self_as'=>'distributor',
            'other_field'=>'distributor',
            'join_table'=>'jos_xrewards'
        ),
        'bvrewards'=>array(
            'class'=>'rewards',
            'join_self_as'=>'distributor',
            'other_field'=>'distributor',
            'join_table'=>'jos_xbvrewards'
        ),
        'specialrewards'=>array(
            'class'=>'rewards',
            'join_self_as'=>'distributor',
            'other_field'=>'distributor',
            'join_table'=>'jos_xspecialrewards'
        )
    );
    var $has_many = array(
        "pinsinaccount" => array(
            "class" => "pin",
            "join_self_as" => "adcrd",
            "other_field" => "adcrd",
            "join_table" => "jos_xtreedetails"
        ),
        "sponsorof" => array(
            "class" => "distributor",
            "join_self_as" => "sponsor",
            "other_field" => "sponsor",
            "join_table" => "jos_xtreedetails"
        ),
        "intrducerof" => array(
            "class" => "distributor",
            "join_self_as" => "introducer",
            "other_field" => "introducer",
            "join_table" => "jos_xtreedetails"
        ),
        "legs" => array(
            "class" => "leg",
            "join_self_as" => "distributor",
            "other_field" => "under",
            "join_table" => "jos_xlegs"
        ),
        'closings' => array(
            'class' => 'xmainclosing',
            'join_self_as' => 'distributor',
            'join_table' => 'jos_xclosingmain',
            'other_field' => 'distributor'
        ),
        'sessionclosings' => array(
            'class' => 'xsessionclosing',
            'join_self_as' => 'distributor',
            'join_table' => 'jos_xclosingsession',
            'other_field' => 'distributor'
        ),
        'donesurveys'=>array(
            'class'=>'distributorsurveys',
            'join_self_as'=>'distributor',
            'join_other_as'=>'survey',
            'other_field'=>'doneby',
            'join_table'=>'jos_xsurvey_done'
        )
    );

    function saveJoomlaUser($id, $pass, $name) {
        global $mainframe;

        // Check for request forgeries
//            JRequest::checkToken() or jexit('Invalid Token');
        // Get required system objects
        $user = clone(JFactory::getUser());
        $config = & JFactory::getConfig();
        $authorize = & JFactory::getACL();
        $document = & JFactory::getDocument();

        // Initialize new usertype setting
        $newUsertype = null; //$usersConfig->get('new_usertype');
        if (!$newUsertype) {
            $newUsertype = 'Registered';
        }

        // Bind the post array to the user object
        $userdata = array();
        $userdata['id'] = "";
        $userdata['name'] = $name;
        $userdata['username'] = $id;
        $userdata['email'] = $id . "@xavoc.com";
        $userdata['password'] = $pass;
        $userdata['password2'] = $pass;
        if (!$user->bind($userdata, 'usertype')) {
            JError::raiseError(500, $user->getError());
        }

        // Set some initial user values
        $user->set('id', 0);
        $user->set('usertype', $newUsertype);
        $user->set('gid', $authorize->get_group_id('', $newUsertype, 'ARO'));

        $date = & JFactory::getDate();
        $user->set('registerDate', $date->toMySQL());

        $useractivation = 0; //$usersConfig->get('useractivation');
        if ($useractivation == '1') {
            jimport('joomla.user.helper');
            $user->set('activation', JUtility::getHash(JUserHelper::genRandomPassword()));
            $user->set('block', '1');
        }

        // If there was an error with registration, set the message and display form
        if (!$user->save()) {
            JError::raiseWarning('', JText::_($user->getError()));
            return false;
        }
        $this->jid = $user->id;
        $this->save();
        return true;
    }

    function getCurrent() {
        $this->get_by_jid(JFactory::getUser()->id);
    }

    function updateAnsesstors() {
        $Path = $this->Path;
        $PV = $this->kit->PV;
        $BV = $this->kit->BV;
        $RP = $this->kit->RP;
        $IntroAmount = $this->kit->AmountToIntroducer;
        $Green = $this->kit->DefaultGreen;


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
        $this->db->query($query);

        global $com_params;
        if ($com_params->get('PlanHasIntroductionIncome')) {
            $updateIntro = "UPDATE
                    jos_xtreedetails
                SET
                    SessionIntros = SessionIntros + 1,
                    MidSessionIntros = MidSessionIntros + 1,
                    ClosingIntros = ClosingIntros + 1,
                    TotalIntroduces = TotalIntroduces +1
                WHERE
                    id=" . $this->introducer->id;
            $this->db->query($updateIntro);

            $leg = $this->findLeg($this->introducer->id);
            $query = "UPDATE
            jos_xlegs
            SET
                SessionIntros = SessionIntros + 1,
                MidSessionIntros = MidSessionIntros + 1,
                ClosingIntros = ClosingIntros + 1
            WHERE
                id=" . $this->introducer->id . "
                AND Leg='$leg'
                ";
            $this->db->query($query);
        }
        return true;
    }

    function findLeg($UnderDistributor) {
        $Path = $this->Path;
        $query = "SELECT Ansesstors.nextChar as inLeg
                    from  jos_xlegs l
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
                    WHERE
                            Ansesstors.id=$UnderDistributor";
        return $this->db->query($query)->row()->inLeg;
    }

    function detailsOf($asTooltip=true) {
        global $com_params;
        $id = $this;
        $details = "";
        $legs = $this->legs->get();
        if ($asTooltip)
            $qt = "\'";
        else
            $qt="'";
        if ($asTooltip) {
            $details .= $id->detail->Name . " ::";
            if ($com_params->get('PlanHasIntroductionIncome'))
                $details .= ( "<b>Introducer ID : </b>" . $id->introducer->id . "<br/>");
            $details .= ( "<b>Kit : </b>" . $id->kit->Name . "<br/>");
            
        }
        $details .= ( "<b>Joined on : </b>" . implode("-", array_reverse(explode("-", $id->JoiningDate))) . "<br/>");
        if ($com_params->get('InformationInToolTip') == "PI")
            return $details;

        if ($com_params->get('InformationInToolTip') == "BI" or $com_params->get('InformationInToolTip') == "BILI") {
            $details .= "<table border=1 width=100%><thead><center><b>Point Details</b></center></thead><tbody>";
            $details .="<tr class=${qt}ui-widget ui-widget-header${qt}>";
            $details .= "<th>#</th>";
            $details .= "<th colspan=" . ($legs->count() == 0 ? 1 : $legs->result_count()) . ">" . $com_params->get('PVTitle') . "</th>";

            if ($com_params->get('UseBV'))
                $details .= "<th colspan=" . ($legs->count() == 0 ? 1 : $legs->result_count()) . ">" . $com_params->get('BVTitle') . "</th>";
            if ($com_params->get('UseRP'))
                $details .= "<th colspan=" . ($legs->count() == 0 ? 1 : $legs->result_count()) . ">" . $com_params->get('RPTitle') . "</th>";
            $details .= "<th colspan=" . ($legs->count() == 0 ? 1 : $legs->result_count()) . ">New Joins</th>";
            $details .="</tr>";

            $details .="<tr>";
            $details .="<td align=${qt}center${qt}>#</td>";
            foreach ($legs as $leg) //For default PV system
                $details .= "<td align=${qt}center${qt}>$leg->Leg</td>";


            if ($com_params->get('UseBV')) {
                foreach ($legs as $leg)
                    $details .= "<td align=${qt}center${qt}>$leg->Leg</td>";
            }
            if ($com_params->get('UseRP')) {
                foreach ($legs as $leg)
                    $details .= "<td align=${qt}center${qt}>$leg->Leg</td>";
            }

            foreach ($legs as $leg) //For New Join
                $details .= "<td align=${qt}center${qt}>$leg->Leg</td>";

            $details .= "</tr>";

            if ($com_params->get('UseSession')) {
                $details .= "<tr>";
                $details .= ( "<td align=${qt}center${qt}><b>" . $com_params->get('SessionTitle') . "</b></td>");
                foreach ($legs as $leg)
                    $details .= ( "<td align=${qt}center${qt}>" . $leg->SessionPV . "</td>");
                if ($com_params->get('UseBV'))
                    foreach ($legs as $leg)
                        $details .= ( "<td align=${qt}center${qt}>" . $leg->SessionBV . "</td>");
                if ($com_params->get('UseRP'))
                    foreach ($legs as $leg)
                        $details .= ( "<td align=${qt}center${qt}>" . $leg->SessionRP . "</td>");
                foreach ($legs as $leg)
                    $details .= "<td align=${qt}center${qt}>" . (($com_params->get('TotalMembers') == 'OnlyGreen') ? $leg->SessionGreenCount : $leg->SessionCount) . "</td>";
                $details .="</tr>";
            }
            if ($com_params->get('UseMidSession')) {
                $details .= "<tr>";
                $details .= ( "<td align=${qt}center${qt}><b>" . $com_params->get('MidSessionTitle') . "</b></td>");
                foreach ($legs as $leg)
                    $details .= ( "<td align=${qt}center${qt}>" . $leg->MidSessionPV . "</td>");
                if ($com_params->get('UseBV'))
                    foreach ($legs as $leg)
                        $details .= ( "<td align=${qt}center${qt}>" . $leg->MidSessionBV . "</td>");
                if ($com_params->get('UseRP'))
                    foreach ($legs as $leg)
                        $details .= ( "<td align=${qt}center${qt}>" . $leg->MidSessionRP . "</td>");
                foreach ($legs as $leg)
                    $details .= "<td align=${qt}center${qt}>" . (($com_params->get('TotalMembers') == 'OnlyGreen') ? $leg->MidSessionGreenCount : $leg->MidSessionCount) . "</td>";
                $details .="</tr>";
            }

//            =================== Week PV is must to show =====================

            $details .= "<tr>";
            $details .= ( "<td align=${qt}center${qt}><b>" . $com_params->get('ClosingTitle') . "</b></td>");
            foreach ($legs as $leg)
                $details .= ( "<td align=${qt}center${qt}>" . $leg->ClosingPV . "</td>");
            if ($com_params->get('UseBV'))
                foreach ($legs as $leg)
                    $details .= ( "<td align=${qt}center${qt}>" . $leg->ClosingBV . "</td>");
            if ($com_params->get('UseRP'))
                foreach ($legs as $leg)
                    $details .= ( "<td align=${qt}center${qt}>" . $leg->ClosingRP . "</td>");
            foreach ($legs as $leg)
                $details .= "<td align=${qt}center${qt}>" . (($com_params->get('TotalMembers') == 'OnlyGreen') ? $leg->ClosingGreenCount : $leg->ClosingCount) . "</td>";
            $details .="</tr>";

//            ===================== TOTAL PVS to show ========================
            $details .= "<tr>";
            $details .= ( "<td align=${qt}center${qt}><b>Total Joinings</b></td>");
            foreach ($legs as $leg)
                $details .= ( "<td align=${qt}center${qt}>" . $leg->TotalPV . "</td>");
            if ($com_params->get('UseBV'))
                foreach ($legs as $leg)
                    $details .= ( "<td align=${qt}center${qt}>" . $leg->TotalBV . "</td>");
            if ($com_params->get('UseRP'))
                foreach ($legs as $leg)
                    $details .= ( "<td align=${qt}center${qt}>" . $leg->TotalRP . "</td>");
            foreach ($legs as $leg)
                $details .= "<td align=${qt}center${qt}>" . (($com_params->get('TotalMembers') == 'OnlyGreen') ? $leg->TotalGreenCount : $leg->TotalCount) . "</td>";
            $details .="</tr>";



            $details .="</tbody></table><br/>";
        }

        if ($com_params->get('InformationInToolTip') == "LI" or $com_params->get('InformationInToolTip') == "BILI") {
            if ($com_params->get('PlanHasLevelIncome')) {
                $lConfig = new xConfig('level_income');
                $details .= "<table border=1 width=100%><thead><center><b>Level Details</b></center></thead><tbody>";
                $details .= "<tr class=${qt}ui-widget ui-widget-header${qt}>";
                $details .= "<th>#</th>";
                $details .= "<th>Total " . (($lConfig->getkey('LevelIncomeBasedOn') == 'DC') ? "Distributors" : $com_params->get('PVTitle')) . "</th>";
                $details .= "<th>New " . (($lConfig->getkey('LevelIncomeBasedOn') == 'DC') ? "Distributors" : $com_params->get('PVTitle')) . "</th>";
                $details .= "</tr>";
                for ($i = 1; $i <= $lConfig->getkey('LevelsToCount'); $i++) {
                    $details .= "<tr>";
                    $details .= "<td>Level $i</td>";
                    $details .= ( "<td>" . $this->getFromLevel($i, "Total", $lConfig->getkey('LevelIncomeBasedOn'), $com_params->get('LevelIncomeRedCount')) . "</td>");
                    $details .= ( "<td>" . $this->getFromLevel($i, "new", $lConfig->getkey('LevelIncomeBasedOn'), $com_params->get('LevelIncomeRedCount')) . "</td>");
                    $details .= "</tr>";
                }
                $details .= "</tbody></table>";
            }
        }
        return $details;
    }

    function getFromLevel($level, $TotalOrNew, $PvOrDistributorCount, $CountRed) {
        global $com_params;
        $c = new xConfig('level_income');
        if ($PvOrDistributorCount == "DC") {
            $q = "SELECT COUNT(*) as ans from jos_xtreedetails";
        } else {
            $q = "SELECT SUM(PV * " . $com_params->get('PVRate') . " * " . $c->getkey('IncomeLevel' . $level) . ") as ans from jos_xtreedetails ";
        }
        $l = "";
        for ($i = 1; $i <= $level; $i++)
            $l .= "_";
        $q .= " where Path like '" . $this->Path . $l . "'";
        if (strtolower($TotalOrNew) == "new") {
            $q .= " and ClosingNewJoining=0";
        }
        if (!$CountRed) {
            $q .= " and GreenDate <> '0000-00-00'";
        }
//        return $q;
        $CI = get_instance();
        $r = $CI->db->query($q);
        return $r->row()->ans;
    }
    
    function shiftME($underNewID){
        $l= new Leg();
        $l->where('distributor_id',$this->sponsor->id)->where('downline_id',$this->id)->get();
        $oldLeg=$l->Leg;
        $oldSponsor=$this->sponsor->id;
        
        $newsp=new Distributor($underNewID);
        if($newsp->legs->count()==0)
            $newLeg='A';
        else{
            $newsp->legs->limit(1)->get();
            $newLeg = ($newsp->legs->Leg == 'A') ? 'B': 'A';
        }
        
        $l->distributor_id=$underNewID;
        $l->Leg = $newLeg;
        $l->save();
        
        $this->sponsor_id=$underNewID;
        $this->save();
        $oldPath=$this->Path;
        $newPath=$newsp->Path . $newLeg ;
        
        $q="UPDATE jos_xtreedetails SET Path=REPLACE(Path,'$oldPath','$newPath')";
        $this->db->query($q);
        
        $sl=new Shift();
        $sl->shifted_id=$this->id;
        $sl->from_id=$oldSponsor;
        $sl->to_id=$underNewID;
        $sl->save();
    }

}

?>