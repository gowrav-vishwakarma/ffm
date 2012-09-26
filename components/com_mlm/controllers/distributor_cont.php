<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class distributor_cont extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function dashboard() {
        $d = new Distributor();
        $d->getCurrent();
        $data['cd'] = $d;
        $this->load->view("distributor.html", $data, false, true);
        $this->jq->getHeader();
    }

    function treeview() {
        $this->load->library("com_params");
        $data['configtreelevels'] = $this->com_params->getGlobalParam('treeLevels');
        $GLOBALS['PlanHasIntroductionIncome'] = $this->com_params->getGlobalParam('PlanHasIntroductionIncome');
        $cd = new Distributor();
        $cd->getCurrent();
        $data['title'] = "Treeview for  " . $cd->detail->Name;
        if ($this->input->post('Start') != '' || $this->input->post('Start') != null) {
            $StartID = $this->input->post('Start');
        } else {
            $StartID = $cd->id;
        }

        $startid = new Distributor();
        $startid->like('Path', $cd->Path)->where('id', $StartID)->get();
        if ($startid->result_count() == 0) {
            JFactory::getApplication()->enqueueMessage("Either ID not Found or ID is not in your Down", 'error');
            $StartID = $cd->id;
            $startid->get_by_id($cd->id);
        }
        $data['cd'] = $startid;
        $this->jq->addJs('js/vertdtree.js');
//        $this->jq->addJs('js/vertdtree.js');
        $this->jq->addCss('css/dtree.css');
        global $com_params;
        JRequest::setVar("layout", $com_params->get('TreeViewStyle'));

        $this->load->view('treeview.html', $data);
        $this->jq->getHeader();
    }

    function personaldetailsform() {
        $cd = new Distributor();
        $cd->getCurrent();
        $d = $cd->detail;

         $c = new xConfig("distributor_area");
        $pinManagerAccess = $c->getKey("PinManagerPasswordProtected");


        $this->load->library("form");
        $f=$this->form->open("personalform", "index.php?option=com_mlm&task=distributor_cont.personaldetailsupdate")
                ->setColumns(1)
                ->div("Name", "name='xx' align='center' style='text-transform:capitalize'", "<b>Name : </b>" . $d->Name)
                ->text("Father / Husband Name", "name='Father_HusbandName' class='input req-string' value='$d->Father_HusbandName'")
                ->select("Gender", "name='Gender' class='not-req' not-req-val='-1'", array("Select Gender" => '-1', "Male" => "M", "Female" => "F"), $d->Gender)
                ->dateBox("Birth date", "name='Dob' value='$d->Dob'")
                ->text("PanNo", "name='PanNo' value='$d->PanNo'")
                ->textArea("Address", "name='Address' class='req-string' cols=20 rows=5", "", $d->Address)
                ->text("City", "name='City'  class='req-string' value='$d->City'")
                ->text("State", "name='State' class='req-string' value='$d->State'")
                ->text("Country", "name='Country' class='req-string' value='$d->Country'")
                ->text("MobileNo", "name='MobileNo' class='req-string req-numeric' value='$d->MobileNo'")
                ->text("Nominee", "name='Nominee' class='req-string' value='$d->Nominee'")
                ->text("RelainWithNominee", "name='RelainWithNominee' class='req-string' value='$d->RelainWithNominee'")
                ->dateBox("NomineeDob", "name='NomineeDob' value='$d->NomineeDob'")
                ->password("Password", "name='Password' class='input req-string req-same' rel='pass' value='$d->Password'")
                ->password("RePassword", "name='RePassword' class='input req-string req-same' rel='pass' value='$d->Password'");
//                if($pinManagerAccess == 1){
//                $f = $f->password("Pin Manager Password", "name='PinPassword' class='input req-string req-same' rel='pinpass' value='$d->PinManagerPassword'")
//                ->password("Pin Manager RePassword", "name='PinRePassword' class='input req-string req-same' rel='pinpass' value='$d->PinManagerPassword'");
//                }
                $f=$f->text("Your Bank", "name='bank' class='input' value='$d->Bank'")
                ->text("IFSC Code", "name='ifsc' value='$d->IFSC'")
                ->text("Account Number", "name='accountnumber' value='$d->AccountNumber'")
                ->submit("UPDATE")
        ;
        $data['form'] = $f->get();
        JRequest::setVar("layout", "personaldetails");
        $this->load->view("distributor.html", $data);
        $this->jq->getHeader();
    }

    function personaldetailsupdate() {
        global $com_params;
         $c = new xConfig("distributor_area");
        $pinManagerAccess = $c->getKey("PinManagerPasswordProtected");


        $cd = new Distributor();
        $cd->getCurrent();
        $dt = $cd->detail;
        $dt->Father_HusbandName = inp("Father_HusbandName");
        $dt->Gender = inp("Gender");
        $dt->Dob = inp("Dob");
        $dt->PanNo = inp("PanNo");
        $pan = $com_params->get('WrongPanNo');
        if (!verifyPAN(inp('panno'), inp('distributorName')) and $pan == 1)
            $dt->PanNo = '';

        $dt->Address = inp("Address");
        $dt->City = inp("City");
        $dt->State = inp("State");
        $dt->Country = inp("Country");
        $dt->MobileNo = inp("MobileNo");
        $dt->Nominee = inp('Nominee');
        $dt->RelainWithNominee = inp("RelainWithNominee");
        $dt->NomineeDob = inp("NomineeDob");
        $dt->Password = inp("Password");
        $dt->Repassword = inp("Repassword");
        $dt->Bank = inp("bank");
        $dt->IFSC = inp('ifsc');
        $dt->AccountNumber = inp('accountnumber');
//        if($pinManagerAccess == 1)
//               $dt->PinManagerPassword = inp('PinPassword');
        $dt->save();
        $this->db->query("UPDATE jos_users SET `password`=MD5('" . inp('Password') . "') where username=" . $cd->id);
        xRedirect("index.php?option=com_mlm&task=distributor_cont.personaldetailsform", "Information Updated");
    }

    function pinmanager() {
        $params = new JParameter(null, 'config.xml');
        echo $params->render();
    }


    function paymentreceipt() {
        $c=new xConfig('distributor_area');
        JRequest::setVar("layout", "paymentreceipt".$c->getkey("PaymentReceiptLayout"));
        $cd = new Distributor();
        $cd->getCurrent();
        $data['cd'] = $cd;
        $this->load->view("distributor.html", $data, false, true);
        $this->jq->getHeader();
    }

    function dataview() {
        $cd = new Distributor();
        $cd->getCurrent();
        $c = new xConfig('distributor_area');
        $start = JRequest::getVar("pagestart", 0);
        $count = JRequest::getVar("pagecount", $c->getkey('RowsInData'));
        $q = "SELECT t.*, dt.Name, dt.MobileNo
                FROM jos_xtreedetails t
                join jos_xpersonaldetails dt on t.id=dt.distributor_id
                WHERE t.Path like '{$cd->Path}%'
                LIMIT $start, $count
            ";
        $data['result'] = $this->db->query($q)->result();
        $data['start'] = $start;
        $data['i'] = $start;
        $data['count'] = $count;
        JRequest::setVar("layout", "dataview");
        $this->load->view("distributor.html", $data);
    }

    function pinmanagerform() {
         $c = new xConfig("distributor_area");
        $pinManagerAccess = $c->getKey("PinManagerPasswordProtected");
        if (!$this->session->userdata('pinmanagerpassword') && $pinManagerAccess == 1)
            xredirect("index.php?option=com_mlm&task=distributor_cont.pinmanagerloginform");

        $cd = new Distributor();
        $cd->getCurrent();
        $d = $cd->detail;
        $c = new xConfig('distributor_area');
        $start = JRequest::getVar("pagestart", 0);
        $count = JRequest::getVar("pagecount", $c->getkey('RowsInData'));
        $q = "SELECT p.*,k.Name
                FROM jos_xpinmaster p
                join jos_xkitmaster k
                on p.kit_id = k.id
                WHERE adcrd_id = $cd->id
             /*   LIMIT $start, $count  */
            ";
        $data['result'] = $this->db->query($q)->result();
        $data['start'] = $start;
        $data['i'] = $start;
        $data['count'] = $count;
        JRequest::setVar("layout", "availablepins");
        $contents = $this->load->view("distributor.html", $data, true);
        $this->jq->addTab(1, "Available Pins", $contents);


        JRequest::setVar("layout", "usedpins");
        $contents = $this->load->view("distributor.html", $data, true);
        $this->jq->addTab(1, "Used Pins", $contents);

        JRequest::setVar("layout", "deactivepins");
        $contents = $this->load->view("distributor.html", $data, true);
        $this->jq->addTab(1, "Deactive Pins", $contents);

        $this->load->library("form");
        $this->form->open("pinTransferForm", "index.php?option=com_mlm&task=distributor_cont.pinTransfer")
                ->text("From DistributorID", "name='fromID' class='input req-string req-numeric'")
                ->text("To DistributorID", "name='toID' class='input req-string req-numeric")
                ->lookupDB('Transfer To', "name='adcrd' class='input req-string req-numeric'", "index.php?option=com_mlm&task=ajax.distributorlist&format=raw", array("a" => "b"), array("distributor_id", "Name"), "distributor_id")
                ->confirmButton("Confirm", "Pin Transfer Confirmation", "index.php?option=com_mlm&format=raw&task=distributor_cont.confirmPinTransfer", true)
                ->submit("Transfer")
        ;

        JRequest::setVar("layout", "actions");
        $data['form'] = $this->form->get();


        $this->form->open("pinStatusChangeForm", "index.php?option=com_mlm&task=distributor_cont.pinStatusChange")
                ->text("From DistributorID", "name='fromID' class='input req-string req-numeric'")
                ->text("To DistributorID", "name='toID' class='input req-string req-numeric")
                ->select("Change Publish Status", "name='published' class='req-string not-req' not-req-val='-1'", array("Change Status to" => "-1", "Published" => "1", "UNPublished" => "0"))
                ->confirmButton("Confirm", "Pin Status Change Confirmation", "index.php?option=com_mlm&format=raw&task=distributor_cont.confirmPinStatusChange", true)
                ->submit("Change Status")
        ;

        JRequest::setVar("layout", "actions");
        $data['form1'] = $this->form->get();

        $contents = $this->load->view("distributor.html", $data, true);
        $this->jq->addTab(1, "Actions", $contents);

        $data1['tabs'] = $this->jq->getTab(1);
        $this->form->open("pinManagerLogout", "index.php?option=com_mlm&task=distributor_cont.pinManagerLogout")
                ->submit("Logout from Pin Manager")
        ;
        $data1['form2'] = $this->form->get();
        JRequest::setVar("layout", "pinstabmanager");
        $this->load->view('distributor.html', $data1);
        $this->jq->getHeader();
    }

    function confirmPinTransfer() {
        $cd = new Distributor();
        $cd->getCurrent();
        $otheradcrd_id = 0;
        $p = new Pin();
        $this->load->library("com_params");
        $x = $this->com_params->getGlobalParam("WhenPinsAreUsed");
        $p->where("id >=", inp('fromID'))
                ->where('id <=', inp('toID'))
                ->where('Used', 1)
                ->get();
        if ($p->result_count() > 0) {
            echo "There are Used pin in between.. ";
            if ($x <= 1) {
                echo "You are not(false) allowed to transfer the pins.";
            } else {
                echo "Are you sure";
            }
        } else {
            for ($i = inp('fromID'); $i <= inp('toID'); $i++) {
                $p = new Pin($i);
                if ($p->adcrd_id != $cd->id) {
                    $otheradcrd_id = 1;
                }
            }
            if ($otheradcrd_id == 1)
                echo "Other distributor has pins in between. Do you still wish to proceed?";
            else
                echo "Are you sure you want to proceed?";
        }
    }

    function confirmPinStatusChange() {
        $cd = new Distributor();
        $cd->getCurrent();
        $otheradcrd_id = 0;
        $p = new Pin();
        global $com_params;
        $x = $com_params->get("WhenPinsAreUsed");
        $p->where("id >=", inp('fromID'))
                ->where('id <=', inp('toID'))
                ->where('Used', 1)
                ->get();
        if ($p->result_count() > 0) {
            echo "There are Used pin in between.. ";
            if ($x < 1) {
                echo "You are not(false) allowed to change status.";
            } else {
                echo "Are you sure";
            }
        } else {
            for ($i = inp('fromID'); $i <= inp('toID'); $i++) {
                $p = new Pin($i);
                if ($p->adcrd_id != $cd->id)
                    $otheradcrd_id = 1;
            }
            if ($otheradcrd_id == 1)
                echo "Other distributor has pins in between. Do you still wish to proceed?";
            else
                echo "Are you sure you want to proceed?";
        }
    }

    function pinTransfer() {
        $cd = new Distributor();
        $cd->getCurrent();
        for ($i = inp('fromID'); $i <= inp('toID'); $i++) {
            $p = new Pin($i);
            if ($p->adcrd_id != $cd->id) {
                continue;
            }
            $p->adcrd_id = inp("adcrd");
            $p->save();
        }
        $pt= new Pintransfer();
        $pt->Fromdistributor_id=$cd->id;
        $pt->Todistributor_id=$p->adcrd_id;
        $pt->Narration=inp('fromID')." to ".inp('toID') ;
        $pt->created_at=getNow();
        $pt->save();
        xRedirect("index.php?option=com_mlm&task=distributor_cont.pinmanagerform");
    }

    function pinStatusChange() {
        $cd = new Distributor();
        $cd->getCurrent();
        for ($i = inp('fromID'); $i <= inp('toID'); $i++) {
            $p = new Pin($i);
            if ($p->adcrd_id != $cd->id) {
                continue;
            }
            $p->published = inp("published");
            $p->save();
        }
        xRedirect("index.php?option=com_mlm&task=distributor_cont.pinmanagerform");
    }

    function mysurveys() {
        $cd = new Distributor();
        $cd->getCurrent();
        $q = "SELECT * FROM jos_xsurveys s WHERE startdate <= '" . date('Y-m-d') . "' and enddate>='" . date('Y-m-d') . "'";
        $data['surveys'] = $this->db->query($q)->result();
        $data['cd'] = $cd;
        JRequest::setVar("layout", "mysurveys");
        $this->load->view('distributor.html', $data);
        $this->jq->getHeader();
    }

    function takeSurvey() {
        $c = new xConfig('survey_config');
        $cd = new Distributor();
        $cd->getCurrent();
        $data['cd'] = $cd;
        $s = new Survey($this->input->get('sid'));
        $data['survey'] = $s;
        $sd = new DistributorSurveys();
        $sd->where('survey_id', $s->id)->where('distributor_id', $cd->id)->get();
        if ($sd->result_count() > 0) {
            echo "You have Already Taken the survey before";
            return;
        }
//                xRedirect("index.php?option=com_mlm&task=distributor_cont.mysurveys","You have already taken this survey","error");

        JRequest::setVar("layout", "takeSurvey_" . $c->getKey("SurveyType"));
        $this->load->view("distributor.html", $data);
        $this->jq->getHeader();
    }

    function doneSurvey() {
        $c = new xConfig('survey_config');
        $cd = new Distributor();
        $cd->getCurrent();
        $data['cd'] = $cd;
        $s = new Survey($this->input->get('sid'));
        $data['survey'] = $s;
        $sd = new DistributorSurveys();
        $sd->where('survey_id', $s->id)->where('distributor_id', $cd->id)->get();
        if ($sd->result_count() > 0) {
            echo "You have already Done this survey Before";
            return;
        }
        $sd->survey_id = $s->id;
        $sd->distributor_id = $cd->id;
        $sd->save();
        echo "This Survey has been marked as Done by You, You can close this window";
    }

    function sessionView() {
        $cd = new Distributor();
        $cd->getCurrent();
        $cd->sessionclosings->get();
        $data['cd'] = $cd;
        JRequest::setVar("layout", "sessionview");
        $this->load->view("distributor.html", $data);
        $this->jq->getHeader();
    }

    function statementview(){
        $cd = new Distributor();
        $c=new xConfig("distributor_area");
        $cd->getCurrent();
        $data['cd']=$cd;
        $l=$c->getkey("StatementLayout");
        if($l=="")
            $l="defaultStatement";
        JRequest::setVar("layout",$c->getkey("StatementLayout"));
        $this->load->view("distributor.html",$data);
        $this->jq->getHeader();
    }

    function printstatement(){
        $cl=new xMainClosing();
        $cl->get($this->input->get("statement"));
        $data['cl']=$cl;
        JRequest::setVar("layout","printStatement");
        $this->load->view("distributor.html",$data);
    }

    function futureReceipt(){
        JRequest::setVar('layout', 'futureReceipt');
        $this->load->view("distributor.html");
        $this->jq->getHeader();
    }

    function rewardstatus() {
//        $c = new xConfig("rewards");
//        $data['c'] = $c;
//        $cd = new Distributor();
//        $cd->getCurrent();
//        $data['cd'] = $cd;
//        $data['Tail'] = $cd->isTailDone();
//        JRequest::setVar("layout", "rewardstatus");
//        $this->load->view("distributor.html", $data);
//        $this->jq->getHeader();
        $cd=new Distributor();
        $cd->getCurrent();
        $data["join"]=$cd->JoiningDate;
       
         //PV Rewards
        $pv=new Specialreward();
        $data['pv']=$pv->where("distributor_id",$cd->id)->get();
//        echo $sprw->reward1;
        JRequest::setVar("layout", "specialrw");
        $contents = $this->load->view("distributor.html", $data, true);
        $this->jq->addTab(1, "Family Millionaires Rewards", $contents);

        
        $sprw=new Rewards();
        $data['special']=$sprw->where("distributor_id",$cd->id)->get();
//        echo $sprw->reward1;
        JRequest::setVar("layout", "allrewards");
        $contents = $this->load->view("distributor.html", $data, true);
        $this->jq->addTab(1, "Future Billionaires Rewards", $contents);

       
        //BV Rewards
//        $bv=new Bvrewards();
//        $data['bv']=$bv->where("distributor_id",$cd->id)->get();
//        echo $sprw->reward1;
//        JRequest::setVar("layout", "bvrw");
//        $contents = $this->load->view("distributor.html", $data, true);
//        $this->jq->addTab(1, "Special Rewards", $contents);
        $data1['tabs'] = $this->jq->getTab(1);
        JRequest::setVar("layout", "rewardstabmanager");
        $this->load->view('distributor.html', $data1);
        $this->jq->getHeader();
    }

    function showMyPinTransaction()
    {
        $cd=new Distributor();
        $cd->getCurrent();
        $pts=new Pintransfer();
        $query="select * from jos_xpintransaction where Fromdistributor_id=".$cd->id." or ToDistributor_id =".$cd->id." ";//,ToDitributorid";
        $data["pts"]=$this->db->query($query)->result();
        JRequest::setVar("layout", "pintransfer");
        $this->load->view('distributor.html', $data);
        $this->jq->getHeader();
    }

     function pinmanagerProtectionForm() {
        $c = new xConfig("distributor_area");
        $pinManagerAccess = $c->getKey("PinManagerPasswordProtected");
        $cd = new Distributor();
        $cd->getCurrent();
        $dt = $cd->detail;
        //if ($pinManagerAccess == 1) {
          //  if ($dt->PinManagerPassword == "" or $dt->PinManagerPassword == null) {
                echo "<h1>PIN MANAGER PASSWORD PROTECTION</h1>";
                $this->load->library("form");
                $this->form->open("personalform", "index.php?option=com_mlm&task=distributor_cont.pinmanagerProtection")
                        ->setColumns(1)
                        ->password("Password", "name='Password' class='input req-string req-same' rel='pass'")
                        ->password("RePassword", "name='RePassword' class='input req-string req-same' rel='pass' ")
                        ->submit("Set Password")
                ;
                $data['form'] = $this->form->get();
                JRequest::setVar("layout", "pinmanagerpassword");
                $this->load->view("distributor.html", $data);
                $this->jq->getHeader();
//            }
//            else
//                xredirect("index.php?option=com_mlm&task=distributor_cont.pinmanagerloginform");
//        }
//        else
//            xredirect("index.php?option=com_mlm&task=distributor_cont.pinmanagerform");
    }

    function pinmanagerProtection() {
        $cd = new Distributor();
        $cd->getCurrent();
        $dt = $cd->detail;
        $dt->PinManagerPassword = inp("Password");
        $dt->save();
        xredirect("index.php?option=com_mlm&task=distributor_cont.pinmanagerloginform");
    }

    function pinmanagerloginform() {
//        $c = new xConfig("distributor_area");
//        $pinManagerAccess = $c->getKey("PinManagerPasswordProtected");
//        if ($this->session->userdata('pinmanagerpassword') =="" or $this->session->userdata('pinmanagerpassword') === false)
//            xredirect("index.php?option=com_mlm&task=distributor_cont.pinmanagerform");

        $this->load->library("form");
        $this->form->open("personalform", "index.php?option=com_mlm&task=distributor_cont.pinmanagerlogin")
                ->setColumns(1)
                ->password("Enter Your Pin Manager Password", "name='PinManagerPassword' class='input req-string req-same' rel='pass'")
                ->submit("Login to Pin Manager")
        ;
        $data['form'] = $this->form->get();
        JRequest::setVar("layout", "pinmanagerlogin");
        $this->load->view("distributor.html", $data);
        $this->jq->getHeader();
    }

    function pinmanagerlogin() {
        $cd = new Distributor();
        $cd->getCurrent();
        $dt = $cd->detail;
        if ($dt->PinManagerPassword == inp("PinManagerPassword")) {
            $this->session->set_userdata('pinmanagerpassword', inp("PinManagerPassword"));
            xredirect("index.php?option=com_mlm&task=distributor_cont.pinmanagerform");
        }
        else
            xredirect("index.php?option=com_mlm&task=distributor_cont.pinmanagerloginform", "Incorrect Pin Manager Password", "error");
    }

    function pinManagerLogout() {
        $this->session->set_userdata('pinmanagerpassword',false);
//        echo $this->session->userdata('pinmanagerpassword');
        xredirect("index.php?option=com_mlm&task=distributor_cont.pinmanagerloginform");
    }


function pinManagerAccess(){
        $c = new xConfig("distributor_area");
        $pinManagerAccess = $c->getKey("PinManagerPasswordProtected");
         $cd = new Distributor();
        $cd->getCurrent();
        $dt = $cd->detail;

        $url = "index.php?option=com_mlm&task=distributor_cont.";
        if($pinManagerAccess){
            if($dt->PinManagerPassword){
                if($this->session->userdata('pinmanagerpassword')){
                     xredirect($url."pinmanagerform");
                }
                else{
                    xredirect($url."pinmanagerloginform");
                }
            }
            else{
                xredirect($url."pinmanagerProtectionForm");
            }
        }
        else{
            xredirect($url."pinmanagerform");
        }
    }
}
?>