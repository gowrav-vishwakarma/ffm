<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class newjoining extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function registrationform() {
        global $com_params;
        $a = new Admin();
        
        $lastrun=$a->getval('LastSessionRun');
            
            $cutOff=array(23);
            $current=getNow('H');
            $date = getNow('Y-m-d');
            
            if($current < 23){
                $date = date("Y-m-d",strtotime(date("Y-m-d", strtotime(getNow('Y-m-d'))) . "-1 day"));
                $proposedlastrun = ($date. " 23:00:00");
            }
            if ($current >=23) {
                $proposedlastrun = ($date. " 23:00:00");
            }
            if($proposedlastrun != $lastrun){
	                xRedirect("index.php","LAST SESSION ($proposedlastrun == $lastrun) NOT RUN AUTOMATICALY. CALL COMPANY","error");;
			return;
                }
                
       	if ($a->getval("NewJoinings") != "Start")
            xRedirect("index.php", "New Joining is Stopped by administrator due to updation in software, please come back soon", "error");
            

        $this->load->library("form");
        $this->load->library("com_params");
        $this->form->open("JoiningForm", "index.php?option=com_mlm&task=newjoining.savejoining")
                ->setColumns(1)
                ->text("Distributor ID", "name='id' class='input req-string'")
                ->text("Pin", "name='pin' class='input req-string'")
                ->lookupDB('Sponsor ID', "name='sponsor' class='input req-string req-numeric'", "index.php?option=com_mlm&task=ajax.distributorlist&format=raw", array("a" => "b"), array("distributor_id", "Name"), "distributor_id");
        if ($this->com_params->getGlobalParam('PlanHasIntroductionIncome')) {
            $this->form->lookupDB('Introducer ID', "name='introducer' class='input req-string req-numeric'", "index.php?option=com_mlm&task=ajax.distributorlist&format=raw", array("a" => "b"), array("distributor_id", "Name"), "distributor_id");
        }
        $this->form
                ->text("Name", "name='distributorName' class='input req-string' value =''")
                ->text("Father/Husband Name", "name='fatherName' class='input req-string' value=''")
                ->dateBox("Date of birth","name='dob' class='input req-string' value=''")
                ->password("Password", "name='password' class='input req-string req-same' rel='pass' value=''")
                ->password("Retype Password", "name='repassword' class='input req-string req-same' rel='pass' value=''")
                ->text("Mobile No", "name='mobile' class='input req-string' value=''")
                ->textArea("Address", "name='address' class='req-string' style='height:40px; width:250px'","","")
                ->text("City", "name='city' class='input req-string' value=''")
                ->text("State","name='state' class='input req-string'")
                ->text("Pin Code","name='pincode' class='input req-string'")
                ->text("Nominee", "name='Nominee' class='input req-string' value=''")
                ->text("Relation With Nominee", "name='Relation' class='input req-string' value=''")
                ->text("Pan No", "name='panno' class='input '")
                ->text("Your Bank", "name='bank' class='input'")
                ->text("IFSC Code", "name='ifsc'")
                ->text("Account Number", "name='accountnumber'");
        if (trim($pl = $com_params->get('ProductList')) !== "") {
            $pl = explode(",", $pl);
            $list = array("Select Product" => "Select Product");
            foreach ($pl as $p) {
                $list += array($p => $p);
            }
            $this->form->select("Select Your Product", "name='product' class='input not-req' not-req-val='Select Product'", $list);
        }
        $this->form->confirmButton("confirm", "Checking Your Entries", "index.php?option=com_mlm&task=newjoining.confirmjoining&format=raw", true);
        $legsinsystem = $this->com_params->getGlobalParam('LegsInSystem');
        if ($legsinsystem != '-1')
            $this->form->text("", "name='Leg' class='req-string not-req' not-req-val='-1' emsg='Leg is not Selected' value='-1'", "display:none");
        $this->form->submit("Goin");
        $data['form'] = $this->form->get();
        $this->load->view("joiningform.html", $data);
        $this->jq->getHeader();
    }

    function confirmjoining() {
        $this->load->library("com_params");
        global $com_params;
        echo "<h3>Almost Done, Just a step away</h3>";
        $p = new Pin();
        $p->where("id", inp('id'))->where('Pin', inp('pin'))->get();
        if ($p->result_count() == 0 or !$p->checkpin()) {
            echo "<dd class='error message fade falsefalse'><ul><li>Either ID or PIN is entered wrong...or this is a used pin</li></ul></dd>";
        }
        $d = new Distributor();
        $d->get_by_id(inp('sponsor'));
        if ($d->result_count() == 0) {
            echo "<dd class='error message fade falsefalse'><ul><li>Sponsor Not Found, Check the sponsor Id again</li></ul></dd>";
        }

        if ($com_params->get('PlanHasIntroductionIncome')) {
            $d = new Distributor();
            $d->get_by_id(inp('introducer'));
            if ($d->result_count() == 0) {
                echo "<dd class='error message fade falsefalse'><ul><li>Introducer Not Found, Check the sponsor Id again</li></ul></dd>";
            }
        }
        $p = $com_params->get('WrongPanNo');
           if ($p != 0) {
            if (inp('panno') != '')
                echo "<dd class='error message fade'><ul><li>Providing a wrong Pan No is a illegal offence.</li></ul></dd>";
            if($p==4 ) {
                if(strlen(trim(inp('panno'))) !=10 and inp('panno')!='')
                    echo "<dd class='error message fade falsefalse'><ul><li>PAN Card is not correct either use the same Name as written on Pan Card, or leave it blank</li></ul></dd>";
            }
            else {
            if (!verifyPAN(inp('panno'), inp('distributorName'))) {
                if ($p == 1 and trim(inp('panno')) != '') {
                    echo "<dd class='error message fade'><ul><li>PAN Card is not correct, Continuing will remove this Pan card</li></ul></dd>";
                } elseif ($p == 2 and trim(inp('panno')) != '') {
                    echo "<dd class='error message fade falsefalse'><ul><li>PAN Card is not correct or use the same Name as written on Pan Card</li></ul></dd>";
                } elseif ($p == 3)
                    echo "<dd class='error message fade falsefalse'><ul><li>PAN Card is not correct or use the same Name as written on Pan Card, Valid Pan No is Must to continue</li></ul></dd>";
            }
            }
        }
        $legsinsystem = $this->com_params->getGlobalParam('LegsInSystem');
        if ($legsinsystem != "-1") {
            $s = new Distributor(inp('sponsor'));
            $s->legs->get();
            $legsfilled = $s->legs->count();
            if ($legsfilled >= $legsinsystem) {
                echo "<dd class='error message fade falsefalse'><ul><li>Sorry No Leg Available</li></ul></dd>";
            } else {
                $leglist = array();
                $leglist +=array("Select Leg" => "-1");
                for ($i = 0; $i < $legsinsystem; $i++) {
                    foreach ($s->legs as $ll) {
                        if ($ll->Leg == chr(65 + $i))
                            continue 2;
                    }
                    $leglist +=array(chr(65 + $i) => chr(65 + $i));
                }
                $this->load->library("form");
                $this->form->open("legForm", "#")
                        ->select("Please select the Leg for your Entry", "name='LegSelect' class='req-string not-req' not-req-val='Select Leg' onchange='jQuery(\"#JoiningForm_Leg\").val(jQuery(this).val())'", $leglist, inp('Leg'));
//                        ->submit("Go");
                $this->jq->getHeader(true);
                echo $this->form->get();
            }
        }
    }

    function savejoining() {
        $a = new Admin();
        if ($a->getval("NewJoinings") != "Start")
            xRedirect("index.php", "New Joining is Stopped by administrator due to updation in software, please come back soon", "error");

//        Check Exsting leg entry error
        $exleg=new Leg();
        $exleg->where('distributor_id', inp('sponsor'))
                ->where('Leg',inp('Leg'));
        if($exleg->result_count() > 0){
            xRedirect("index.php", "This Leg is already filled kinldy refresh your registration page and retry, please come back soon", "error");
        }

        $noexception = true;
        global $com_params;
        try {
            $this->db->trans_begin();
            $this->load->library("com_params");
            $legsinsystem = $this->com_params->getGlobalParam('LegsInSystem');
            $afterRegister = $this->com_params->getGlobalParam('WhereToGoAfterRegistration');

            $l = new Leg();
            $l->distributor_id = inp('sponsor');
            if ($legsinsystem == "-1") {
                $newleg = new Leg();
                $newleg->where('distributor_id', inp('sponsor'))->get();
                $i = $newleg->result_count();
                $leg = chr(65 + $i);
            } else {
                $leg = inp('Leg');
                if($leg=='-1')
                   xRedirect("index.php", "The Leg selection has made a problem, Kindly retry, NO ERTRY IS DONE", "error"); 
            }

            $p = new Pin();
            $p->get_by_Pin(inp('pin'));
            $p->result_count();
            if (!$p->checkpin()) {
                $this->db->trans_rollback();
                xRedirect("index.php?option=com_mlm&task=newjoining.registrationform", "Pin shows some critical error, not Registered", "error");
                return;
            }

            $d = new Distributor();
            $d->id = inp('id');
            $d->sponsor_id = inp('sponsor');
            $d->introducer_id = inp('introducer');
            $d->pin_id = $p->id;
            $d->kit_id = $p->kit->id;
            $d->adcrd_id = $p->adcrd_id;

            $d->PV = $p->PV;
            $d->BV = $p->BV;
            $d->RP = $p->RP;

            $sp = new Distributor();
            $sp->get_by_id(inp('sponsor'));
            $d->Path = $sp->Path . $leg;

            $dt = new Details();
            $dt->Name = inp('distributorName');
            $dt->Father_HusbandName = inp('fatherName');
            $dt->Password = inp('password');
            $dt->distributor_id = inp('id');
            $dt->Address = inp('address');
            $dt->City=inp('City');
            $dt->Dob=inp('dob');
                        $dt->State=inp('state');
                                    $dt->PinCode=inp('pincode');
            $dt->Nominee=inp('Nominee');
            $dt->RelainWithNominee=inp('Relation');
            $dt->MobileNo = inp('mobile');
            $dt->Bank = inp("bank");
            $dt->IFSC = inp('ifsc');
            $dt->AccountNumber = inp('accountnumber');

            if (trim($pl = $com_params->get('ProductList')) !== "") {
                $dt->Product=inp('product');
            }


            $dt->PanNo = inp('panno');
            $pan = $com_params->get('WrongPanNo');
            if (!verifyPAN(inp('panno'), inp('distributorName')) and $pan == 1)
                $dt->PanNo = '';


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

            $sp=new Specialreward();
            $sp->distributor_id=$d->id;
            $spclrw=$sp->save();

            $bvr=new Bvrewards();
            $bvr->distributor_id=$d->id;
            $bvrw=$sp->save();

            $rewardsSaved = $rwd->save();
            $pinsaved = $p->save();
            $detailsaved = $dt->save();
            $legsaved = $l->save();
            $jsaved = $d->saveJoomlaUser($d->id, inp('password'), inp('distributorName'));
            $anssaved = $d->updateAnsesstors();
        } catch (Exception $e) {
            $noexecption = false;
        }

        if ($this->db->trans_status() === FALSE or !$bvrw or !$spclrw or !$dsaved or !$pinsaved or !$detailsaved or !$legsaved or !$jsaved or !$noexception or !$rewardsSaved) {
            $this->db->trans_rollback();
            xRedirect("index.php?option=com_mlm&task=newjoining.registrationform", "There has been some critical error, not Registered", "error");
            return;
        } else {
            $this->db->trans_commit();
        }

        $sms = new sms();
        $sms->newjoiningsms($dt->MobileNo, $d->id, $dt->Password);
        $msg = "You have successfuly Registered";
        $type = "info";

        if ($afterRegister == 1) {
            global $mainframe;
            $mainframe->login(array('username' => inp('id'), 'password' => inp('password')));
            $dispatcher = & JDispatcher::getInstance();
            $results = $dispatcher->trigger('onxmlmNewJoining', array($s));
            xRedirect("index.php?option=com_mlm&task=newjoining.welcome", "You are now Registered and logged in");
        }

        $dispatcher = & JDispatcher::getInstance();
        $results = $dispatcher->trigger('onxmlmNewJoining', array($d));
        xRedirect("index.php?option=com_mlm&task=newjoining.welcome&did=".inp('id'), $msg, $type);
// xRedirect("index.php?option=com_mlm&task=newjoining.registrationform", $msg, $type);
    }

    function welcome() {

         $d = new Distributor();
         $d->get_by_id(JRequest::getVar('did',0));

        if(!$d->exists()){
           $d->getCurrent();
        }

        $dispatcher = & JDispatcher::getInstance();
        $results = $dispatcher->trigger('onxmlmNewJoining', array($d));
        $data["distributor"]=$d;
        JRequest::setVar('layout', 'welcomeletter');
        $this->load->view('distributor.html',$data);
        $this->jq->getHeader();
    }

}

?>