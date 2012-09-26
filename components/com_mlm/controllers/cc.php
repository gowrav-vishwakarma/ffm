<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class cc extends CI_Controller {

    function __construct() {
        parent::__construct();
        $u = JFactory::getUser();
//        if ($u->usertype == null)
//            xRedirect("index.php?option=com_mlm", "You are not Authorised for Closings", "error");
    }

    function index() {
        xMlmToolBars::defaultCloingToolBar();
        $this->load->view("closings.html");
    }
    
    function rw()
    {
        $c=new xConfig('rewards');
        $r=array(0,$c->getkey('Reward1_PairPoint')*1000,$c->getkey('Reward2_PairPoint')*1000,$c->getkey('Reward3_PairPoint')*1000,$c->getkey('Reward4_PairPoint')*1000,$c->getkey('Reward5_PairPoint')*1000,$c->getkey('Reward6_PairPoint')*1000,$c->getkey('Reward7_PairPoint')*1000,$c->getkey('Reward8_PairPoint')*1000,$c->getkey('Reward9_PairPoint')*1000);
        
        for($i=1;$i<9;$i++)
        {
//            XREWARDS IS ACTUALLY RP, GREEN ID BASED SPECIAL REWARDS
//            $sql="update jos_xrewards re
//            inner join
//                ( SELECT DISTINCT(Drps.id), Drps.m as msrp,r.distributor_id from jos_xrewards r
//                    inner join (
//				    SELECT t.id , RPS.m from jos_xtreedetails t
//                                        inner join
//                                            (
//                                               select min(MidSessionRP) as m,distributor_id as d
//                                               from jos_xlegs
//                                               where distributor_id in(select distributor_id from jos_xlegs group by distributor_id having count(Leg)=2) group by distributor_id
//                                            )As RPS
//					on RPS.d=t.id
//                            )As Drps
//                    on Drps.id=r.distributor_id
//                )as res
//            on res.distributor_id=re.distributor_id
//            set re.Reward$i='".getNow()."'
//            where res.msrp>='$r[$i]' and re.Reward$i=date('0000-00-00 00:00:00')";            
//            
            $q="UPDATE jos_xrewards re
                inner join
                (
                    select t.id , t.TotalPairRP
                        FROM
                            jos_xtreedetails t
                            LEFT OUTER JOIN jos_xlegs AS `left` ON t.id = `left`.distributor_id
                            LEFT OUTER JOIN jos_xlegs AS `right` ON t.id = `right`.distributor_id
                        WHERE
                            `left`.Leg = 'A' AND
                            `right`.Leg = 'B'
                ) as myT
                on myT.id= re.distributor_id
                SET
                re.Reward$i='".getNow()."'
                WHERE 
                re.Reward$i='0000-00-00 00:00:00' AND
                myT.TotalPairRP >= ".$r[$i].""
                    ;
            
            $this->db->query($q);
       }

//       $query=  "update jos_xrewards r
//                inner join
//                (select distributor_id,MidSessionPV
//                    from jos_xlegs
//                    WHERE
//                    MidSessionPV>=250
//                    GROUP BY distributor_id
//                    having count(Leg)=2 and sum(MidSessionPV)>=750)
//                    as x
//                    on x.distributor_id=r.distributor_id
//                    set r.Tail='".getnow()."'
//                    where r.Tail='0000-00-00 00:00:00'";
//       //echo $query;
//       $this->db->query($query);

//       //###########     New BV Rewards     ##############//
//       $i=1;
//       $reqBV=array(
//            /*
//            'pairs' => 'days'
//             */
//            "10"=>"10",
//            "40"=>"30",
//            "100"=>"45",
//            "180"=>"100000",
//            "280"=>"60",
//            "455"=>"180",
//            "705"=>"365",
//            "1205"=>"730",
//            "2705"=>"100000",
//            "7705"=>"100000");
//       foreach($reqBV as $keyBV=>$valueBV){
//            $sql1="UPDATE jos_xbvreward re
//                    inner JOIN
//                    (
//                        select
//                        t.id,
//                        t.JoiningDate,
//                        IF((LeftSide.MidSessionBV is null),0,LeftSide.MidSessionBV) as LeftBV,
//                        IF((RightSide.MidSessionBV is null),0,RightSide.MidSessionBV) as RightBV
//                        from jos_xtreedetails t
//                        left outer join
//                        (
//                            Select * from jos_xlegs where Leg='A'
//                        ) as LeftSide on t.id=LeftSide.distributor_id
//                        left outer JOIN
//                        (
//                            Select * from jos_xlegs where Leg='B'
//                        ) as RightSide on t.id=RightSide.distributor_id
//                        /*WHERE
//                        DATE_ADD(t.JoiningDate,INTERVAL $valueBV DAY) > '".  getNow()."'*/ /* Pased its days limits */
//                        HAVING /*Both side less then req BV*/
//                        (LeftBV >= $keyBV and (LeftBV is not null))
//                        AND
//                        (RightBV >= $keyBV and (RightBV is not null))
//                    ) as Tmp
//                    on Tmp.id=re.distributor_id
//                    SET
//                        re.reward$i='".getNow()."'
//                    WHERE
//                        re.reward$i='0000-00-00 00:00:00'";
//            $sql2="UPDATE jos_xbvreward re
//                    inner JOIN
//                    (
//                        select
//                        t.id,
//                        t.JoiningDate,
//                        IF((LeftSide.MidSessionBV is null),0,LeftSide.MidSessionBV) as LeftBV,
//                        IF((RightSide.MidSessionBV is null),0,RightSide.MidSessionBV) as RightBV
//                        from jos_xtreedetails t
//                        left outer join
//                        (
//                            Select * from jos_xlegs where Leg='A'
//                        ) as LeftSide on t.id=LeftSide.distributor_id
//                        left outer JOIN
//                        (
//                            Select * from jos_xlegs where Leg='B'
//                        ) as RightSide on t.id=RightSide.distributor_id
//                        WHERE
//                        DATE_ADD(t.JoiningDate,INTERVAL $valueBV DAY) < '".  getNow()."' /*not Passed its days limits */
//                        HAVING /*Both side less then req BV*/
//                        (LeftBV < $keyBV and (LeftBV is not null))
//                        AND
//                        (RightBV < $keyBV and (RightBV is not null))
//                    ) as Tmp
//                    on Tmp.id=re.distributor_id
//                    SET
//                        re.reward$i='1970-01-01 00:00:00'
//                    WHERE
//                        re.reward$i='0000-00-00 00:00:00'";
//            $i++;
//            $this->db->query($sql2);
//            $this->db->query($sql1);
//       }


       //###########     New PV Rewards     ##############//
       $i=1;
       $reqPV=array(
            /*
            'days' => 'pairs'
             */
            "30"=>"10000",
            "60"=>"35000",
            "90"=>"85000",
            "180"=>"335000");
       foreach($reqPV as $keyPV=>$valuePV){
            $sql1="UPDATE jos_xspecialreward re
                    inner JOIN 
                    (
                        select
                        t.id,
                        t.JoiningDate,
                        IF((LeftSide.MidSessionPV is null),0,LeftSide.MidSessionPV) as LeftPV,
                        IF((RightSide.MidSessionPV is null),0,RightSide.MidSessionPV) as RightPV
                        from jos_xtreedetails t
                        left outer join
                        (
                            Select distributor_id, MidSessionPV from jos_xlegs where Leg='A'
                        ) as LeftSide on t.id=LeftSide.distributor_id
                        left outer JOIN
                        (
                            Select distributor_id, MidSessionPV from jos_xlegs where Leg='B'
                        ) as RightSide on t.id=RightSide.distributor_id
                        /* === comment from here 
                        WHERE
                        DATE_ADD(t.JoiningDate,INTERVAL +$keyPV DAY) > '".  getNow()."' 
                           ==== comment till here */ /* Passed its days limits */
                        HAVING /*Both side less then req PV*/
                        (LeftPV >= $valuePV and (LeftPV is not null))
                        AND
                        (RightPV >= $valuePV and (RightPV is not null))
                    ) as Tmp
                    on Tmp.id=re.distributor_id
                    SET
                        re.reward$i='".getNow()."'
                    WHERE
                        re.reward$i='0000-00-00 00:00:00'";
            $sql2="UPDATE jos_xspecialreward re
                    inner JOIN
                    (
                        select
                        t.id,
                        t.JoiningDate,
                        IF((LeftSide.MidSessionPV is null),0,LeftSide.MidSessionPV) as LeftPV,
                        IF((RightSide.MidSessionPV is null),0,RightSide.MidSessionPV) as RightPV
                        from jos_xtreedetails t
                        left outer join
                        (
                            Select * from jos_xlegs where Leg='A'
                        ) as LeftSide on t.id=LeftSide.distributor_id
                        left outer JOIN
                        (
                            Select * from jos_xlegs where Leg='B'
                        ) as RightSide on t.id=RightSide.distributor_id
                        WHERE
                        DATE_ADD(t.JoiningDate,INTERVAL $keyPV DAY) < '".  getNow()."' /*not Passed its days limits */
                        HAVING /*Both side less then req PV*/
                        (LeftPV < $valuePV )
                        OR
                        (RightPV < $valuePV)
                    ) as Tmp
                    on Tmp.id=re.distributor_id
                    SET
                        re.reward$i='1970-01-01 00:00:00'
                    WHERE
                        re.reward$i='0000-00-00 00:00:00'";
            $i++;
            $this->db->query($sql2);
            $this->db->query($sql1);
            
       }
       echo "done";

    }
    function a() {
       date_default_timezone_set('Asia/Calcutta');
        $noexception = true;
        try {
            $this->db->trans_begin();
            $a = new Admin();
            $c= new xConfig('closings_config');
            $sessionclosing=$c->getkey('SessionClosing');
            
            $thisHour = strtotime(getNow());
           
            
            if($sessionclosing ==0)
                return;
            if(($sessionclosing==1 and JRequest::getVar('manual')!='1' )){
                echo "pass with mannual variable";
                return;
            }

            if(JRequest::getVar("manual",0) != 0){
	            $current=getNow('H');
        	    $date = getNow('Y-m-d');
	            if($current < 23){
        	        $date = date("Y-m-d",strtotime(date("Y-m-d", strtotime(getNow('Y-m-d'))) . "-1 day"));
	                $proposedlastrun = ($date. " 23:00:00");
	            }
	            if ($current >=23) {
	                $proposedlastrun = ($date. " 23:00:00");
	            }
                	$thisHour=strtotime($proposedlastrun);
            }
            
            $timings=$c->getkey('SessionTimings');

            $timings=explode(",",$timings);
            $lastHour = strtotime($a->getval('LastSessionRun'));
            $lastDate=date("Y-m-d H:00:00",$lastHour);
            $lastHour = date("H", $lastHour);

            $thisDate=date("Y-m-d H:00:00",$thisHour);
            $thisHourHour = date("H", $thisHour);

            $cutOff = array();
            foreach($timings as $t)
                $cutOff = array_merge (array($t),$cutOff);

	    echo JRequest::getVar("manual",0); 
            if(!in_array($thisHourHour, $cutOff) and JRequest::getVar("manual",0)==0){
                echo "1 Returning at " . getNow();
                return;
            }
            if($lastDate == $thisDate){
                 echo "2 Returning at " . getNow();
                return;
            }
            $thisHour = date("Y-m-d H:00:00", $thisHour);
            
	    /*echo "Closing now at $thisHour";
	    $this->db->trans_rollback();
	    return;
	    echo "oops i should not be on ur screen";
            */
            $this->_doSessionClosing();

            $a->setval('LastSessionRun', $thisHour);
        } catch (Exception $e) {
            $noexecption = false;
        }
        if ($this->db->trans_status() === FALSE or !$noexception) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    function sessionClosing() {
        
    }

    function _doSessionClosing() {
        $admin = new Admin();
        $admin->setval('NewJoinings', 'Stop');
        global $com_params;
        $Closing = new xSessionClosing();
        if ($com_params->get('BinarySystem')) {
            $Closing->setSessionBinary();
        }
        $admin->setval('NewJoinings', 'Start');
    }

    
    function familyrewardscorrection(){
        $reqPV=array(
            /*
            'days' => 'pairs'
             */
            "30"=>"10000",
            "60"=>"35000",
            "90"=>"85000",
            "180"=>"335000");
        $i=1;
       foreach($reqPV as $keyPV=>$valuePV){
        $q="select 
                t.* 
            FRom 
                jos_xtreedetails t 
            inner join jos_xspecialreward re on re.distributor_id=t.id            
            WHERE
                re.reward$i <> '0000-00-00 00:00:00'
           AND 
                re.reward$i <> '1970-01-01 00:00:00'
            ";
        $result=$this->db->query($q)->result();
        
        foreach($result as $d){
            
            $path=$d->Path;
            $jd=$d->JoiningDate;

            $q="
                SELECT 
                    SUM(SessionLeftPV) LEFTPVS,
                    SUM(SessionRightPV) RIGHTPVS
                from 
                jos_xclosingsession
                WHERE
                distributor_id=$d->id
                AND
                Session Between '$jd' AND '".date('Y-m-d',strtotime($jd)+ (60*60*24*($keyPV+1)))."'
                ";
//            echo $q;
            $completedPair=$this->db->query($q)->row();
            if($completedPair->LEFTPVS < $valuePV OR $completedPair->RIGHTPVS < $valuePV){
                echo "<b>$d->id has $completedPair->LEFTPVS lefts and $completedPair->RIGHTPVS in right with in $keyPV days of his joining</b> <br/>";
                $qq="UPDATE jos_xspecialreward SET reward$i ='1970-01-01 00:00:00' WHERE distributor_id=$d->id";
                //$this->db->query($qq);  // UNCOMMENT TO CORRECT
            }
            else
                echo "$d->id has $completedPair->LEFTPVS lefts and $completedPair->RIGHTPVS in right with in $keyPV days of his joining<br/>";
        }
        
        
        $i++;
       }
    }
    
}