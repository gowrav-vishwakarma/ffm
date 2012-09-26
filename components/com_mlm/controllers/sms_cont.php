<?php

/* ------------------------------------------------------------------------
  # com_xcideveloper - Seamless merging of CI Development Style with Joomla CMS
  # ------------------------------------------------------------------------
  # author    Xavoc International / Gowrav Vishwakarma
  # copyright Copyright (C) 2011 xavoc.com. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
  # Websites: http://www.xavoc.com
  # Technical Support:  Forum - http://xavoc.com/index.php?option=com_discussions&view=index&Itemid=157
  ------------------------------------------------------------------------- */
// no direct access
defined('_JEXEC') or die('Restricted access');
?><?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class sms_cont extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $c = $this->input->get('content');
        $no = $this->input->get('msisdn');

        $s = explode(" ", $c);

        switch (strtolower($s[1])) {
            case 'cp':
                $this->getCp($s);
                break;
            case 'lp':
                $this->getLP($s);
                break;
            case 'pd':
                $this->getPD($s);
                break;
            case 'nj':
                $this->newJoining($s);
                break;
            case 'pass';
                $this->getPassword($s);
                break;
            case 'help':
                $this->help($s);
                break;
            default:
                $this->help($s, "Sorry there is no such command");
        }
    }

    function helpOnCommand($ca) {
        global $com_params;
        switch ($ca[2]) {
            case 'cp':
                echo $ca[0] . " cp yourID yourPassword\n\nfor your current position";
                break;
            case 'lp':
                echo $ca[0] . " lp yourID yourPassword\n\nfor your Last payout details";
                break;
            case 'pd':
                echo $ca[0] . " pd yourID yourPassword\n\nfor your personal details";
                break;
            case 'nj':
                echo $ca[0] . " nj newID PIN SponsorID Leg";
                if ($com_params->get('PlanHasIntroductionIncome'))
                    echo " IntroducerID";
                echo " MobileNo FirstName\n";
                echo "(Use A/B in place Left/Right)";
                break;
            case 'pass':
                echo $ca[0]. " pass yourID\n";
                echo "Only works if yourID is registered with the number from which you are sending this request";
                    break;
            default:
                $this->help($ca[1], "Sorry there is no such command");
        }
    }

    function help($ca, $msg="") {
        if(isset($ca[2])){
            $this->helpOnCommand($ca);
            return;
        }
        echo $msg . "\n";
        echo "Commands you can use\n";
        echo $ca[0] . " help: this help\n";
        echo $ca[0] . " cp: current position\n";
        echo $ca[0] . " lp: Last Payout\n";
        echo $ca[0] . " pd: Personal Details\n";
        echo $ca[0] . " nj: New Joining\n";
        echo $ca[0] . " pass: Get Your Password\n";
    }

    function getPD($ca) {
        if (count($ca) != 4) {
            echo "Incorrect use of command. to know you details send this message\n";
            echo $ca[0] . " pd yourID yourPassword";
            return;
        }
        $pd = new Details();
        $pp = $pd->where('distributor_id', $ca[2])->where('Password', $ca[3])->get()->result_count();
        $details = "";
        if ($pp) {
            $name = explode(" ", $pd->Name);
            $name = $name[0];
            $d = $pd->detailsof;
            $msg = "Dear Sir, your details:\n";
            $msg .= ( "Name: " . $pd->Name . "\n" );
            $msg .= ( "Sponsor: " . $pd->detailsof->sponsor_id . "\n");
            $msg .= ( "Introducer: " . $pd->detailsof->introducer_id . "\n" );
            $msg .= ( "Kit: " . $pd->detailsof->kit->Name . "\n");
            $msg .= ( "Join: " . $pd->detailsof->JoiningDate);

            echo $msg;
        }
        else
            echo "Sorry, Your Username and/or Password is wrong";
    }

    function newJoining($ca) {

        global $com_params;
        

        if ($com_params->get('PlanHasIntroductionIncome')) {
            $moveone = 1;
            $totalcount = 9;
        } else {
            $moveone = 0;
            $totalcount = 8;
        }
        if (count($ca) != $totalcount) {
            echo "Incorrect use. \n";
            echo $ca[0] . " nj newID PIN SponsorID Leg";
            if ($com_params->get('PlanHasIntroductionIncome'))
                echo " IntroducerID";
            echo " MobileNo FirstName\n";
            echo "(Use A/B for leg instead Left/Right)";
            return;
        }
        
        $sID = $ca[2];
        $sPin = $ca[3];
        $sSponsor = $ca[4];
        $sLeg = $ca[5];

        $sIntroducer = $ca[5 + $moveone];
        $sMobile = $ca[6 + $moveone];
        $sName = $ca[7 + $moveone];


        $a = new Admin();
        if ($a->getval("NewJoinings") != "Start") {
            echo "New Joining is Stopped by administrator due to updation in software, please try after short time";
            return;
        }

//        Check Exsting leg entry error
        $exleg = new Leg();
        $exleg->where('distributor_id', $sSponsor)
                ->where('Leg', $sLeg)->get();
        if ($exleg->result_count() > 0) {
            echo "This Leg is already filled";
            return;
        }
//        Check for correct sponsor
        $sp = new Distributor();
        $sp->get_by_id($sSponsor);
        if ($sp->result_count() == 0) {
            echo "Sponsor ID not found";
            return;
        }

//        Check for correct Introducer
        if ($com_params->get('PlanHasIntroductionIncome')) {
            $sp = new Distributor();
            $sp->get_by_id($sIntroducer);
            if ($sp->result_count() == 0) {
                echo "Introducer ID not found";
                return;
            }
        }

        $noexception = true;

        try {
            $this->db->trans_begin();
            $this->load->library("com_params");
            $legsinsystem = $this->com_params->getGlobalParam('LegsInSystem');
            $afterRegister = $this->com_params->getGlobalParam('WhereToGoAfterRegistration');

            $l = new Leg();
            $l->distributor_id = $sSponsor;
            if ($legsinsystem == "-1") {
                $newleg = new Leg();
                $newleg->where('distributor_id', $sSponsor)->get();
                $i = $newleg->result_count();
                $leg = chr(65 + $i);
            } else {
                $leg = $sLeg;
            }

            $p = new Pin();
            $p->get_by_Pin($sPin);
            $p->result_count();
            if (!$p->checkpin()) {
                $this->db->trans_rollback();
                echo "Pin is Either used or UnPublished by Owner";
                return;
            }

            $d = new Distributor();
            $d->id = $sID;
            $d->sponsor_id = $sSponsor;
            $d->introducer_id = $sIntroducer;
            $d->pin_id = $p->id;
            $d->kit_id = $p->kit->id;
            $d->adcrd_id = $p->adcrd_id;

            $d->PV = $p->PV;
            $d->BV = $p->BV;
            $d->RP = $p->RP;

            $d->Path = $sp->Path . $leg;

            $dt = new Details();
            $dt->Name = $sName;
            $dt->Father_HusbandName = "-";
            $dt->Password = $sMobile;
            $dt->distributor_id = $sID;
            $dt->Address = "-";
            $dt->City = "-";
            $dt->Nominee = "-";
            $dt->RelainWithNominee = "-";
            $dt->MobileNo = $sMobile;
            $dt->Bank = "-";
            $dt->IFSC = "-";
            $dt->AccountNumber = "-";

            if (trim($pl = $com_params->get('ProductList')) !== "") {
                $dt->Product = "-";
            }


            $dt->PanNo = "";
            $pan = $com_params->get('WrongPanNo');
            if (!verifyPAN(inp('panno'), inp('distributorName')) and $pan == 1)
                $dt->PanNo = '';

            $d->JoiningDate = getNow();
            if ($p->kit->DefaultGreen)
                $d->GreenDate = getNow();
            else
                $d->GreenDate = "0000-00-00";


            $l->Leg = $leg;

            $dsaved = $d->save_as_new();
            $p->Used = 1;
            $l->downline_id = $d->id;

            $rwd = new Rewards();
            $rwd->distributor_id = $d->id;

            $rewardsSaved = $rwd->save();
            $pinsaved = $p->save();
            $detailsaved = $dt->save();
            $legsaved = $l->save();
            $jsaved = $d->saveJoomlaUser($d->id, $sMobile, $sName);
            $anssaved = $d->updateAnsesstors();
        } catch (Exception $e) {
            $noexecption = false;
        }

        if ($this->db->trans_status() === FALSE or !$dsaved or !$pinsaved or !$detailsaved or !$legsaved or !$jsaved or !$noexception or !$rewardsSaved) {
            $this->db->trans_rollback();
            echo "There has been some critical error, not Registered";
            return;
        } else {
            $this->db->trans_commit();
        }

        $sms = new sms();
        $sms->newjoiningsms($dt->MobileNo, $d->id, $dt->Password);
        $msg = "You have successfuly Registered a new Joining";
        echo $msg;
    }

    function getPassword($ca){
        $no=$this->input->get('msisdn');
        $no=substr(trim($no),-10);
        $pd=new Details();
        $pd->where('distributor_id',$ca[2])->where('MobileNo',$no)->get();
        if($pd->result_count() == 0){
            echo "Sorry! This Mobile No is not registered with this ID";
            return;
        }
        echo "Your Password is " . $pd->Password;
    }
/*

    // =============== RCEARN SPECIFIC ======================
    function getCp($ca) { //RCEARN
        //        format("company","cp","ID","Password")
        if (count($ca) != 4) {
            echo "Incorrect use of command. to know you details send this message\n";
            echo $ca[0] . " cp yourID yourPassword";
            return;
        }
        $pd = new Details();
        $pp = $pd->where('distributor_id', $ca[2])->where('Password', $ca[3])->get()->result_count();
        $details = "";
        if ($pp) {
            $name = explode(" ", $pd->Name);
            $name = $name[0];
            $d = $pd->detailsof;
            $legs = $d->legs->get();
            foreach ($legs as $leg) {//For default PV system
                $details .= "$leg->Leg : ";
                $details .= $leg->SessionPV . "\n";
            }
            $msg = "Dear " . $name . " Your current position is as follows \n";
            $msg .= $details;
            echo $msg;
        }
        else
            echo "Sorry, Your Username and/or Password is wrong";
    }

    function getLP($ca) {
        if (count($ca) != 4) {
            echo "Incorrect use of command. to know you details send this message\n";
            echo $ca[0] . " lp yourID yourPassword";
            return;
        }
        $pd = new Details();
        $pp = $pd->where('distributor_id', $ca[2])->where('Password', $ca[3])->get()->result_count();
        if ($pp) {
            $cd = $pd->detailsof;
            $cd->closings->order_by("id", "desc")->get(1);
            $cl = $cd->closings;
            $msg = $cl->closing . " :: \n";

            if ($cl->LastClosingCarryAmount > 0)
                $msg .= "Prv: " . $cl->LastClosingCarryAmount . "\n";

            if ($cl->IntroductionAmount > 0)
                $msg .= "Intr: " . $cl->IntroductionAmount . "\n";
            if ($cl->BinaryIncomeFromIntrosShare > 0)
                $msg .= "Bstr: " . $cl->BinaryIncomeFromIntrosShare . "\n";

            $msg .= " Bnr: " . $cl->BinaryIncome . "\n";

            if ($cl->RoyaltyIncome > 0)
                $msg .="Royt: " . $cl->RoyaltyIncome . "\n";

            $msg .= "Totl: " . $cl->ClosingAmount . "\n";
            $msg .= "Tds: " . $cl->ClosingTDSAmount . "\n";
            $msg .="Srv: " . $cl->ClosingServiceCharge . "\n";

            if ($cl->ClosingUpgradationDeduction > 0)
                $msg .= "Upgd: " . $cl->ClosingUpgradationDeduction . "\n";

            if ($cl->$cl->OtherDeductions > 0)
                $msg .=" Socl: " . $cl->OtherDeductions . "\n";

            if ($cl->FirstPayoutDeduction > 0)
                $msg .="Frst: " . $cl->FirstPayoutDeduction . "\n";

            $msg .="Net: " . $cl->ClosingAmountNet . "\n";

            if ($cl->ClosingCarriedAmount > 0)
                $msg .= "Carry: " . $cl->ClosingCarriedAmount;

            echo $msg;
        }
        else
            echo "Sorry, Your Username and/or Password is wrong";
    }

*/    

      //    =================== FFM SPECIFIC ========================
      function getCp($ca) { // FAMILY FUTURE BUSINESS
      //        format("company","cp","ID","Password")
      if(count($ca) != 4){
      echo "Incorrect use of command. to know you details send this message\n";
      echo $ca[0]. " cp yourID yourPassword";
      return;
      }
      $pd = new Details();
      $pp = $pd->where('distributor_id', $ca[2])->where('Password', $ca[3])->get()->result_count();
      $details = "";
      if ($pp) {
      $name = explode(" ", $pd->Name);
      $name = $name[0];
      $d = $pd->detailsof;
      $legs = $d->legs->get();
      foreach ($legs as $leg) {//For default PV system
      $details .= "$leg->Leg : ";
      $details .= $leg->SessionPV . "\n";
      }
      $msg = "Dear " . $name . " Your current position is as follows \n";
      $msg .= $details;
      echo $msg;
      }
      else
      echo "Sorry, Your Username and/or Password is wrong";
      }

      function getLP($ca) {
      if(count($ca) != 4){
      echo "Incorrect use of command. to know you details send this message\n";
      echo $ca[0]. " lp yourID yourPassword";
      return;
      }
      $pd = new Details();
      $pp = $pd->where('distributor_id', $ca[2])->where('Password', $ca[3])->get()->result_count();
      if ($pp) {
      $cd = $pd->detailsof;
      $cd->closings->order_by("id", "desc")->get(1);
      $cl = $cd->closings;
      $msg = $cl->closing . " :: \n";
      if ($cl->LastClosingCarryAmount > 0)
      $msg .= "Prv: " . $cl->LastClosingCarryAmount . "\n";
      $msg .= " Bnr: " . $cl->BinaryIncome . "\n";
      $msg .= "Totl: " . $cl->ClosingAmount . "\n";
      $msg .= "Tds: " . $cl->ClosingTDSAmount . "\n";
      $msg .="Srv: " . $cl->ClosingServiceCharge . "\n";

      if ($cl->ClosingUpgradationDeduction > 0)
      $msg .= "Upgd: " . $cl->ClosingUpgradationDeduction . "\n";

      $msg .=" Socl: " . $cl->OtherDeductions . "\n";

      if ($cl->FirstPayoutDeduction > 0)
      $msg .="Frst: " . $cl->FirstPayoutDeduction . "\n";

      $msg .="Net: " . $cl->ClosingAmountNet . "\n";

      if ($cl->ClosingCarriedAmount > 0)
      $msg .= "Carry: " . $cl->ClosingCarriedAmount;


      echo $msg;
      }
      else
      echo "Sorry, Your Username and/or Password is wrong";
      }
     
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */