<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class admindistributor_cont extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function dashboard() {
        xMlmToolBars::distributorToolBar();
        $this->load->view('distributor.html');
        $this->jq->getHeader();
    }

    function search() {
        xMlmToolBars::distributorSearchToolBar();
        $k = new Kit();
        $this->load->library('form');
        $this->form->open("DistributorSearch", "index.php?option=com_mlm&task=admindistributor_cont.searchresult&format=raw", "target='_blank'")
                ->lookupDB('ID', "name='distributorid' class='input req-numeric'", "index.php?option=com_mlm&task=ajax.distributorlist&format=raw", array("a" => "b"), array("distributor_id", "Name"), "distributor_id")
                ->text("Name", "name='name' class='input'")
                ->select("Kit", "name='kit'", $k->getKitList(true))
                ->lookupDB('AdcRd', "name='adcrd' class='input req-numeric'", "index.php?option=com_mlm&task=ajax.distributorlist&format=raw", array("a" => "b"), array("distributor_id", "Name"), "distributor_id")
                ->text("Address/City/State/District", "name='area' class='input'")
                ->text("Mobile No", "name='mobile' class='input'")
                ->text("PanNo", "name='panno' class='input'")
                ->lookupDB('UNDER ID', "name='underid' class='input req-numeric'", "index.php?option=com_mlm&task=ajax.distributorlist&format=raw", array("a" => "b"), array("distributor_id", "Name"), "distributor_id")
                ->dateBox("Joining After", "name='joiningafter' class='input'")
                ->dateBox("Joining Before", "name='joiningbefore' class='input'")
                ->confirmButton("Confirm", "Search Result", "index.php?option=com_mlm&task=admindistributor_cont.searchresultajax&format=raw")
                ->submit("go");

        $data['searchForm'] = $this->form->get();
        JRequest::setVar('layout', 'searchform');
        $this->load->view('distributor.html', $data);
        $this->jq->getHeader();
    }

    function searchresultajax() {
        $d = new Details();
        if (inp('distributorid') != '') {
            $d->where('distributor_id', inp('distributorid'));
        }
        if (inp('name') != '')
            $d->like('Name', inp('name'));
        if (inp('kit') != '-1')
            $d->where_related_detailsof('kit_id', inp('kit'));
        if (inp('joiningafter') != '')
            $d->where_related_detailsof('JoiningDate >=', inp('joiningafter'));
        if (inp('joiningbefore') != '')
            $d->where_related_detailsof('JoiningDate <', inp('joiningbefore'));
        if (inp('underid') != '') {
            //echo inp('underid');
            $nd = new Distributor();
            $nd->get_by_id(inp('underid'));
            $x = $nd->like("Path", $nd->Path)->get();
            $d->where_related_detailsof('id', $x);
        }
        $d->get();

        $data['result'] = $d;
        JRequest::setVar('layout', 'searchresultajax');
        $this->load->view('distributor.html', $data);
        $this->jq->getHeader();
    }

    function searchresult() {
        $this->load->helper('download');

        $d = new Details();
        if (inp('distributorid') != '') {
            $d->where('distributor_id', inp('distributorid'));
        }
        if (inp('name') != '')
            $d->like('Name', inp('name'));
        if (inp('kit') != '-1')
            $d->where_related_detailsof('kit_id', inp('kit'));
        if (inp('joiningafter') != '')
            $d->where_related_detailsof('JoiningDate >=', inp('joiningafter'));
        if (inp('joiningbefore') != '')
            $d->where_related_detailsof('JoiningDate <', inp('joiningbefore'));
        if (inp('underid') != '') {
            $nd = new Distributor();
            $nd->get_by_id(inp('underid'));
            $x = $nd->like("Path", $nd->Path)->get();
            $d->where_related_detailsof('id', $x);
        }
        $d->join_related('detailsof/kit', 'Name');
        $d->join_related('detailsof', 'JoiningDate');
        $result = $this->db->query($d->get_sql());
        $this->load->dbutil();
        $data = $this->dbutil->csv_from_result($result);

        $name = 'distgributorSearch.csv';
        force_download($name, $data);
    }

    function distributorActionPage() {
        xMlmToolBars::distributorActionPageToolBar();
        $d = new Details();
        $d->get_by_distributor_id($this->input->get('did'));
        $c = new xConfig('editing_id_tree');
        $this->load->library("form");
        $this->form->open("personalform", "index.php?option=com_mlm&task=admindistributor_cont.personaldetailsupdate")
                ->setColumns(1);
        if ($c->getkey('AllowEditingName')) {
            $this->form->text("Name", "name='name' class='input req-string' value='$d->Name'");
        } else {
            $this->form->div("Name", "name='name'", $d->Name);
            $this->form->hidden('', "name='name' value='$d->Name'");
        }
        $this->form->text("Father / Husband Name", "name='Father_HusbandName' class='input req-string' value='$d->Father_HusbandName'")
                ->select("Gender", "name='Gender' class='not-req' not-req-val='-1'", array("Select Gender" => '-1', "Male" => "M", "Female" => "F"), $d->Gender)
                ->dateBox("Birth date", "name='Dob' value='$d->Dob'")
                ->text("PanNo", "name='PanNo' value='$d->PanNo'")
                ->textArea("Address", "name='Address' class='req-string'", "", $d->Address)
                ->text("City", "name='City'  class='req-string' value='$d->City'")
                ->text("State", "name='State' class='req-string' value='$d->State'")
                ->text("Country", "name='Country' class='req-string' value='$d->Country'")
                ->text("MobileNo", "name='MobileNo' class='req-string req-numeric' value='$d->MobileNo'")
                ->text("Nominee", "name='Nominee' class='req-string' value='$d->Nominee'")
                ->text("RelainWithNominee", "name='RelainWithNominee' class='req-string' value='$d->RelainWithNominee'")
                ->dateBox("NomineeDob", "name='NomineeDob' value='$d->NomineeDob'")
                ->{$c->getkey('SeeUserPassword')}("Password", "name='Password' class='input req-string req-same' rel='pass' value='$d->Password'")
                ->{$c->getkey('SeeUserPassword')}("RePassword", "name='RePassword' class='input req-string req-same' rel='pass' value='$d->Password'")
                ->{$c->getkey('SeeUserPassword')}("PIN Password", "name='PINPassword' class='input req-string req-same' rel='pinpass' value='$d->PinManagerPassword'")
                ->{$c->getkey('SeeUserPassword')}("Re PIN Password", "name='RePINPassword' class='input req-string req-same' rel='pinpass' value='$d->PinManagerPassword'")
                ->select("Published", "name='published' class='input'", array('Published' => '1', 'UNPublished' => '0'), $d->detailsof->published)
                ->hidden("", "name='did' value='$d->distributor_id'")
                ->submit("UPDATE")
        ;

        $this->jq->addTab(1, "Edit Personal Details", $this->form->get());

        if ($c->getkey('AllowKitChange')) {
            $k = new Kit();
            $this->form->open('kitchangeform', "index.php?option=com_mlm&task=admindistributor_cont.changeKit")
                    ->div('ExitingKitDiv', '', " Current Kit For <b>" . $d->Name . "</b> is <b><big>" . $d->detailsof->kit->Name . "</big></b>")
                    ->select("New Kit", "name='newkit' class='input not-req' not-req-val='" . $d->detailsof->kit->id . "' emsg='change kit, cannot update same kit'", $k->getKitList(), $d->detailsof->kit->id)
                    ->confirmButton("Confirm", "Change Kit", "index.php?option=com_mlm&task=admindistributor_cont.changeKitConfirm&format=raw")
                    ->hidden("", "name='did' value='$d->distributor_id'")
                    ->submit("Go");
            $this->jq->addTab(1, "Change Kit", $this->form->get());
        }

        $data['form'] = $this->jq->getTab(1);
        JRequest::setVar("layout", "editdistributor");
        $this->load->view("distributor.html", $data);
        $this->jq->getHeader();
    }

    function personaldetailsupdate() {
        $cd = new Distributor();
        $cd->get_by_id($this->input->post('did'));
        $dt = $cd->detail;
        $dt->Name = inp('name');
        $dt->Father_HusbandName = inp("Father_HusbandName");
        $dt->Gender = inp("Gender");
        $dt->Dob = inp("Dob");
        $dt->PanNo = inp("PanNo");
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
        $dt->PinManagerPassword = inp("PINPassword");
        $cd->published = inp('published');
        $cd->save();

        $dt->save();
        $this->db->query("UPDATE jos_users SET `password`=MD5('" . inp('Password') . "') where username=" . $cd->id);
        xRedirect("index.php?option=com_mlm&task=admindistributor_cont.distributorActionPage&did=$cd->id", "Information Updated");
    }

    function changeKitConfirm() {
        echo "confirm ?";
    }

    function getInvoice() {
        xMlmToolBars::distributorSearchToolBar();
        $this->load->library('form');
        $this->form->open("invoice", "index.php?option=com_mlm&task=admindistributor_cont.futureReceipt&format=raw", "target=ffm")
                ->lookupDB('ID', "name='distributorid' class='input req-numeric'", "index.php?option=com_mlm&task=ajax.distributorlist&format=raw", array("a" => "b"), array("distributor_id", "Name"), "distributor_id")
//                ->selectAjax("Distrbutor ID","name='ddlDist' class='input' req-not-val=-1'",$a)
                ->submit("submit");
        $data['form'] = $this->form->get(); //$this->jq->getTab(1);
        JRequest::setVar("layout", "getInvoice");
        $this->load->view("distributor.html", $data);
        $this->jq->getHeader();
    }

    function generateBill() {
        $id = $this->input->post("distributorid");
        $ts = new Distributor();
        $ts->where("id", $id)->get();
        $data['cd'] = $ts;
        JRequest::setVar("layout", "generateInvoice");
        $this->load->view("distributor.html", $data);
        $this->jq->getHeader();
    }

    function SMS() {
        xMlmToolBars::distributorSearchToolBar();
        //echo "Hello";
        $this->load->library('form');
        $this->form->open("smsbyID", "index.php?option=com_mlm&task=admindistributor_cont.doSMSByID&format=raw")
                ->text('ID', "name='distributorid' class='input'")//, "index.php?option=com_mlm&task=ajax.distributorlist&format=raw", array("a" => "b"), array("distributor_id", "Name"), "distributor_id")
                ->textarea('Message', "name='txtMsg'")
//                ->selectAjax("Distrbutor ID","name='ddlDist' class='input' req-not-val=-1'",$a)
                ->submit("submit");
        $this->jq->addTab(1, "Message By Distributor ID", $this->form->get());
        $this->load->library('form');
        $this->form->open("smsbyNum", "index.php?option=com_mlm&task=admindistributor_cont.doSMSByNum&format=raw")
                ->text('Number', "name='distributorid' class='input req-string'")
                ->textarea('Message', "name='txtMsg'") ////, "index.php?option=com_mlm&task=ajax.distributorNO&format=raw", array("a" => "b"), array("Name", "MobileNo"), "MobileNo")
//                ->selectAjax("Distrbutor ID","name='ddlDist' class='input' req-not-val=-1'",$a)
                ->submit("submit");
        $this->jq->addTab(1, "Message By Distributor Mobile No", $this->form->get());
        $data['form'] = $this->jq->getTab(1);
        JRequest::setVar("layout", "sms");
        $this->load->view("distributor.html", $data);
        $this->jq->getHeader();
    }

    function doSMSByID() {
        $by = $this->input->post("distributorid");
        $msg = $this->input->post("txtMsg");
        $individual = explode(",", $by);
        $unique = array_count_values($individual);
        foreach ($unique as $k => $v) {
            $d = new Details();
            $mobile = $d->where("distributor_id", $k)->get()->MobileNo;
            if (strlen(strrev(trim($mobile))) >= 10)
                $s->sendsms($mobile, $msg);
        }
        xRedirect("index.php?option=com_mlm&task=admindistributor_cont.SMS", "Message Sent");
    }

    function doSMSByNum() {
        $by = $this->input->post("distributorid");
        $msg = $this->input->post("txtMsg");
        $s = new sms();
        //$s->sendsms($by, $msg);
        $individual = explode(",", $by);
        $mobile = array_count_values($individual);
        foreach ($mobile as $k => $v) {
            if (strlen(strrev(trim($k))) == 10) {
                $s->sendsms($k, $msg);
            }
        }
        xRedirect("index.php?option=com_mlm&task=admindistributor_cont.SMS", "Message Sent");
    }

    function futureReceipt() {
        JRequest::setVar('layout', 'futureReceipt');
        $data['id'] = $this->input->post('distributorid');
        $this->load->view("distributor.html", $data);
        $this->jq->getHeader();
    }

    function shiftidform() {
        xMlmToolBars::cancleDefault("Shift ID", "admindistributor_cont.dashboard");
        $this->load->library("form");
        $this->form->open("shiftIDForm", "index.php?option=com_mlm&task=admindistributor_cont.shiftID")
                ->lookupDB('SHIFT ID', "name='distributorid' class='input req-numeric'", "index.php?option=com_mlm&task=ajax.distributorlist&format=raw", array("a" => "b"), array("distributor_id", "Name", "SponsorID"), "distributor_id")
                ->lookupDB('New Sponsor', "name='newsponsorid' class='input req-numeric'", "index.php?option=com_mlm&task=ajax.distributorlist&format=raw", array("a" => "b"), array("distributor_id", "Name", "SponsorID"), "distributor_id")
                ->confirmButton("Confirm", "ChangeSponsor", "index.php?option=com_mlm&task=admindistributor_cont.shiftidconfirm&format=raw")
                ->submit("ShiftID");
        ;
        echo "<h1>ID Shift Form, Please be carefull </h1>";
        $data['form'] = $this->form->get();
        JRequest::setVar("layout", "shiftidform");
        $this->load->view("distributor.html", $data);
        $this->jq->getHeader();
    }

    function shiftidconfirm() {
        $d = new Distributor(inp('distributorid'));
        $newsp = new Distributor(inp('newsponsorid'));
        if (!$newsp->exists()) {
            echo "New Sponsor Does Not exists. false movement";
            return;
        }
        if ($newsp->legs->get()->count() == 2) {
            echo "All legs full to the target, false movement found.";
            return;
        }
        if(!$d->exists()){
            echo "ID to move does not exists, false movement detected";
            return;
        }
        if(strpos($newsp->Path, $d->Path) !== false){
            echo "$newsp->id is itself under $d->id, false movement detected";
            return;
        }
        if($newsp->legs->count()==0)
            $newLeg='A';
        else{
            $newsp->legs->limit(1)->get();
            $newLeg = ($newsp->legs->Leg == 'A') ? 'B': 'A';
        }
        //$newLeg= chr($newsp->legs->count() + 65);
        echo "READY TO MOVE $d->id under $newsp->id in $newLeg Side";
    }

    function shiftID() {
        try {
            $this->db->trans_begin();
            $d = new Distributor(inp('distributorid'));
            $d->shiftME(inp('newsponsorid'));
        } catch (Exception $e) {
            $this->db->trans_rollback();
            xRedirect("index.php?option=com_mlm&task=admindistributor_cont.shiftidform", "ID NOT Shifted ", "error");
        }
        $this->db->trans_commit();
        xRedirect("index.php?option=com_mlm&task=admindistributor_cont.shiftidform", "ID Shifted Successfully");
    }

}