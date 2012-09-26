<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class pins_cont extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function dashboard() {
        xMlmToolBars::PinsManagementToolBar();

        $kit = new Kit();

        $this->load->library("form");
        $this->form->open("pinGenerateForm", "index.php?option=com_mlm&task=pins_cont.generatepins")
                ->text("No Of Pins", "name='noofpins' class='input req-string req-numeric'")
                ->lookupDB('Alloted To', "name='adcrd' class='input req-string req-numeric'", "index.php?option=com_mlm&task=ajax.distributorlist&format=raw", array("a" => "b"), array("distributor_id", "Name"), "distributor_id")
                ->select("For Kit", "name='kit' class='req-string not-req' not-req-val='-1'", $kit->getKitList(true))
                ->submit("Generate")
        ;

        $this->jq->addTab(1, "Generate New Pins", $this->form->get());

        $this->form->open("pinPublishStatusForm", "index.php?option=com_mlm&task=pins_cont.changePublishStatus")
                ->text("From DistributorID", "name='fromID' class='input req-string req-numeric'")
                ->text("To DistributorID", "name='toID' class='input req-string req-numeric")
                ->select("Change Publish Status", "name='published' class='req-string not-req' not-req-val='-1'", array("Change Status to" => "-1", "Published" => "1", "UNPublished" => "0"))
                ->confirmButton("Confirm", "Change Pin Status Confirmation", "index.php?option=com_mlm&format=raw&task=pins_cont.confirmPinStatusChange", true)
                ->submit("Change Status")
        ;


        $this->jq->addTab(1, "Change Publish Status", $this->form->get());

        $this->form->open("pinTransferForm", "index.php?option=com_mlm&task=pins_cont.pinTarnsfer")
                ->text("From DistributorID", "name='fromID' class='input req-string req-numeric'")
                ->text("To DistributorID", "name='toID' class='input req-string req-numeric")
                ->lookupDB('Transfer To', "name='adcrd' class='input req-string req-numeric'", "index.php?option=com_mlm&task=ajax.distributorlist&format=raw", array("a" => "b"), array("distributor_id", "Name"), "distributor_id")
                ->confirmButton("Confirm", "Pin Transfer Confirmation", "index.php?option=com_mlm&format=raw&task=pins_cont.confirmPinTransfer", true)
                ->submit("Change Status")
        ;

        $this->jq->addTab(1, "Transfer Pins", $this->form->get());

        $this->form->open("pinSearchForm", "index.php?option=com_mlm&format=raw&task=pins_cont.pinsearchDownload","target='_blank'")
                ->text("From DistributorID", "name='fromID' class='input req-numeric'")
                ->text("To DistributorID", "name='toID' class='input req-numeric'")
//                ->lookupDB('Transfer To',"name='adcrd' class='input req-string req-numeric'","index.php?option=com_mlm&task=ajax.distributorlist&format=raw",array("a"=>"b1"),array("distributor_id","Name"),"distributor_id")
                ->select("For Kit", "name='kit'", $kit->getKitList(true))
                ->select("Publish Status", "name='published'", array("Any" => "-1", "Published" => "1", "UNPublished" => "0"))
                ->select("Used Status", "name='used'", array("Any" => "-1", "Used" => "1", "UNUsed" => "0"))
//                ->checkBox("Download Result", "name='download' value='yes'")
                ->confirmButton("Confirm", "Pin Search Result Page", "index.php?option=com_mlm&format=raw&task=pins_cont.pinSearch&layout=pinsearchresult", true)
                ->submit("Change Status")
        ;
        $this->jq->addTab(1, "Search Pins", $this->form->get());
        $data['tabs'] = $this->jq->getTab(1);
        $this->load->view('pins.html', $data);
        $this->jq->getHeader();
    }

    function generatepins() {
        $this->load->library("com_params");
        $DefaultPinStatus = $this->com_params->getGlobalParam("DefaultPinStatus");
        $p = new Pin();
        $x = $p->generatePins(inp('adcrd'), inp('kit'), inp('noofpins'), $DefaultPinStatus);
        xRedirect("index.php?option=com_mlm&task=pins_cont.dashboard", "Pins Generated from " . $x['StartID'] . " to " . $x['EndID']);
    }

    function confirmPinStatusChange() {
        $p = new Pin();
        $this->load->library("com_params");
        $x = $this->com_params->getGlobalParam("WhenPinsAreUsed");
        $p->where("id >=", inp('fromID'))
                ->where('id <=', inp('toID'))
                ->where('Used', 1)
                ->get();
        if ($p->result_count() > 0) {
            echo "There are Used pin in between.. ";
            if ($x == 0) {
                echo "You are not(false) allowed to change status.";
            } else {
                echo "Are you sure";
            }
        } else {
            echo "Confirm And Proceed to Change the status";
        }
    }

    function changePublishStatus() {
        $p = new Pin();
        $p->where("id >=", inp('fromID'))
                ->where('id <=', inp('toID'))
                ->update('published', inp('published'));
        xRedirect("index.php?option=com_mlm&task=pins_cont.dashboard", "Pins " . ((inp('published') == 1) ? "Published" : "UNPublished") . " from " . inp('fromID') . " to " . inp('toID'));
    }

    function confirmPinTransfer() {
        $p = new Pin();
        global $com_params;
        $x = $com_params->get("WhenPinsAreUsed");
        $p->where("id >=", inp('fromID'))
                ->where('id <=', inp('toID'))
                ->where('Used', 1)
                ->get();
        if ($p->result_count() > 0) {
            echo "There are Used pin in between.. ";
            if ($x <= 1) {
                echo "You are not(false) allowed to change status.";
            } else {
                echo "Are you sure";
            }
        } else {
            echo "Confirm And Proceed to Change the status";
        }
    }

    function pinSearch() {
        $p = new Pin();
        if (inp('fromID') != '')
            $p->where('id >=', inp('fromID'));
        if (inp('toID') != '')
            $p->where('id <=', inp('toID'));
        if (inp('kit') != '-1')
            $p->where('kit_id', inp('kit'));
        if (inp('published') != '-1')
            $p->where('published', inp('published'));
        if (inp('used') != '-1')
            $p->where('Used', inp('used'));


        $data['searchedpins'] = $p->get();
        $this->load->view("pins.html", $data);

        $this->jq->getHeader();
    }

    function pinsearchDownload() {
        $this->load->helper('download');
        $p = new Pin();
        if (inp('fromID') != '')
            $p->where('id >=', inp('fromID'));
        if (inp('toID') != '')
            $p->where('id <=', inp('toID'));
        if (inp('kit') != '-1')
            $p->where('kit_id', inp('kit'));
        if (inp('published') != '-1')
            $p->where('published', inp('published'));
        if (inp('used') != '-1')
            $p->where('Used', inp('used'));


        $result=$this->db->query($p->get_sql());
        $this->load->dbutil();
        $data=$this->dbutil->csv_from_result($result);

        $name = 'pinsearchresult.csv';
        force_download($name, $data);
    }

}
//$pt= new Pintransfer();
//        $pt->Fromdistrbutor_id=;
//        $pt->Todistrbutor_id=;
//        $pt->Narration=$startID." to ".$endID." pins are transfered from ".." to ".;