<?php

class closing_cont extends CI_Controller {

    function __construct() {
        parent::__construct();
        
    }

    function index() {
        xMlmToolBars::defaultCloingToolBar();
        $this->load->view("closings.html");
    }

    function mainclosing() {
        xMlmToolBars::mainClosingToolBar();
        $c = new xConfig('closings_config');
        $nextDate=strtotime(date('Y-m-d'));
        $nextDate += (24* 60 *60);
        $nextDate=date("Y-m-d",$nextDate);
        $this->load->library('form');
        if ($c->getkey('MainClosing') == 1) {
           
            $this->form->open('MainClosingReport', "index.php?option=com_mlm&task=closing_cont.downloadMainClosingReport")
                    ->lookupDB("Closing Name", "name='closing' class='input req-string'", "index.php?option=com_mlm&task=ajax.getMainClsoingsNames&format=raw", array(), array('closing'), "closing")
                    ->confirmButton("confirm", "Report View", "index.php?option=com_mlm&task=closing_cont.showMainClosingReport&format=raw");
            $this->form->submit("Show Report");
            $this->jq->addTab(1, "Payment Details", $this->form->get());



            $this->form->open('Statement', "index.php?option=com_mlm&task=closing_cont.showStatement&format=raw","target='_shayona'")
                    ->text("From DistributorID", "name='fromID' class='input req-string req-numeric'")
                    ->text("To DistributorID", "name='toID' class='input req-string req-numeric")
                    ->lookupDB("Closing Name", "name='closing' class='input req-string'", "index.php?option=com_mlm&task=ajax.getMainClsoingsNames&format=raw", array(), array('closing'), "closing")
                    ->checkBox("Only Payable","name='onlypayable' value='yes'");
            $this->form->submitNoHide("Print Statement");
            $this->jq->addTab(1, "Statement", $this->form->get());


 $this->form->open('MainClosingForm', "index.php?option=com_mlm&task=closing_cont.doMainClosing")
                    ->text("Closing Name", "name='closing' class='input req-string'")
                    ->hidden("Performing Closing Till", "name='tilldate' class='input' value='" . $nextDate . "'", $nextDate);
            if ($c->getkey('UseSimulation') == 1) {
                $this->form->text("Simulation Percentage", "name='simulation' class='input'")
                        ->text("Over Income (-1 for all)", "name='simulationFrom' class='input req-string'");
            }
            $this->form->confirmButton("Confirm", "Pre Closing Summery", "index.php?option=com_mlm&task=closing_cont.confirmMainClosing&format=raw")
                    ->submit("Do Closing");
            $this->jq->addTab(1, "New Closing", $this->form->get());
        }
        $data['forms'] = $this->jq->getTab(1);
        JRequest::setVar('layout', 'mainclosing');
        $this->load->view('closings.html', $data);
        $this->jq->getHeader();
    }

    function confirmMainClosing() {
        $u = JFactory::getUser();
        //if ($u->usertype == 'Manager')
        //    xRedirect("index.php?option=com_mlm", "You are not Authorised for Closings", "error");
        global $com_params;
$clname= new xMainClosing();
        $clname->where('closing',inp('closing'))->limit(1)->get()   ;
        if($clname->exists()){
            echo "<div class='falsefalse'>THIS CLOSING NAME IS ALREADY IN USE</div>";
        }

        $Closing = new xMainClosing();
        if ($com_params->get('PlanHasIntroductionIncome')) {
            echo $Closing->confirmUpdateIntroductionIncome(inp('tilldate'));
        }
        if ($com_params->get('BinarySystem')) {
            $closingDistributors = new Distributor();
            $TotalClosingCount = $closingDistributors->where("ClosingNewJoining", "0")->where("JoiningDate <", inp("tilldate"))->count();
            $cds = new Distributor();
            $cds->select_sum("ClosingPairPV")->where("JoiningDate <", inp("tilldate"))->get();
            echo "Total Joinings $TotalClosingCount and Toal Pair Amount $cds->ClosingPairPV";
        }
        if ($com_params->get('PlanHasLevelIncome')) {
            
        }

        $this->jq->getHeader();
    }

    function doMainClosing() {
        $u = JFactory::getUser();
        //if ($u->usertype == 'Manager')
        //    xRedirect("index.php?option=com_mlm", "You are not Authorised for Closings", "error");
        $noexception = true;
        try {
            $this->db->trans_begin();
            $admin = new Admin();
            $admin->setval('NewJoinings', 'Stop');
            global $com_params;
            $Closing = new xMainClosing();
            $tilldate = inp('tilldate');

            if ($com_params->get('PlanHasIntroductionIncome')) {
                $Closing->updateIntroductionIncome($tilldate);
            }
            if ($com_params->get('BinarySystem')) {
                $Closing->updatePVBinaryAndFinalize();
                if ($com_params->get("RPAsBinary")) {
//                    Updated IDS from last closing taken in count here
                    $Closing->updateRPBinaryAndFinalize();
                }
                $bc = new xConfig("binary_income");
                if ($bc->getkey("BinaryShareToIntro") > 0) {
                    $Closing->updateBinaryIncomeFromIntrosShare();
                }
            }
            if ($com_params->get('PlanHasLevelIncome')) {
                $Closing->updateRMB($tilldate);
                $Closing->updateLevelIncome($tilldate);
            }
            if ($com_params->get('PlanHasSurveyIncome')) {
                $Closing->updateSurveyIncome();
            }
            if ($com_params->get('PlanHasRoyaltyIncome')) {
                $Closing->updateRoyaltyIncome();
            }

            $Closing->calculateTotalIncome($tilldate);
            $Closing->calculateDeductions($tilldate);
            $Closing->calculateNetAmount($tilldate);
            $Closing->setCarryForwardAmount($tilldate);
            $Closing->saveclosing(inp('closing'), $tilldate);
            $Closing->finish($tilldate);
            $admin->setval('NewJoinings', 'Start');
        } catch (Exception $e) {
            $noexecption = false;
        }
        if ($this->db->trans_status() === FALSE or !$noexception) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

//    function mainclosingReports() {
//        $c = new xConfig('closings_config');
//        $this->load->library('form');
//        if ($c->getkey('MainClosing') == 1) {
//            $this->form->open('MainClosingReport', "index.php?option=com_mlm&task=closing_cont.showMainClosingReport")
//                    ->lookupDB("Closing Name", "name='closing' class='input req-string'", "index.php?option=com_mlm&task=ajax.getMainClsoingsNames&format=raw", array(), array('closing'), "closing")
//                    ->select("Report", "name='reportstyle' class='input'", array("Normal" => "Normal", "Detailed" => "Detailed", "Enlarged" => "Enlarged"))
//                    ->select("Format", "name='format' class='input'", array('html' => 'html', 'excel' => 'xls'));
//            $this->form->submitNoHide("Show Report");
//            $this->jq->addTab(1, "Payment Details", $this->form->get());
//        }
//        $data['forms'] = $this->jq->getTab(1);
//        JRequest::setVar('layout', 'mainclosing');
//        $this->load->view('closings.html', $data);
//        $this->jq->getHeader();
//    }

    function showMainClosingReport() {
        JRequest::setVar('layout', 'mainClosingReportIn_html');
        $mc = new xMainClosing();
        $mc->where('closing', inp('closing'))->where('ClosingAmount >' ,'0')->get();
        $data['data'] = $mc;
        $matter = $this->load->view('reports.html', $data, true);
        echo $matter;
    }

    function downloadMainClosingReport() {
        JRequest::setVar('layout', 'mainClosingReportIn_xls');
        $mc = new xMainClosing();
        $mc->where('closing', inp('closing'))->where('ClosingAmount >' ,'0')->get();
        $data['data'] = $mc;
        $matter = $this->load->view('reports.xls', $data, true);
        $this->load->helper('download');
        $name = 'report.csv';
        force_download($name, $matter);
    }


    function showStatement(){
        JRequest::setVar('layout','statement');
        $mc = new xMainClosing();
        $mc->where("distributor_id >=", inp('fromID'));
        $mc->where('distributor_id <=', inp('toID'));
        $mc->where('closing', inp('closing'));
        if(inp('onlypayable')=='yes'){
            $mc->where('ClosingAmountNet >',0);
        }
        $mc->get();
        $levelIncome = new xConfig("level_income");
        $data['levelincome'] = $levelIncome;
        foreach($mc as $m){
            $data['data'] = $m;
            $this->load->view('reports.html', $data);
        }
    }
    function dateWiseRewards(){
        xMlmToolBars::mainClosingToolBar();
        $this->load->library('form');
        $this->form->open("rewardlist","index.php?option=com_mlm&task=closing_cont.downloadList")
                ->setColumns(2)
                ->dateBox("Start Date","name='sdate' class='input req-string'")
                ->dateBox("End Date","name='edate' class='input req-string'")
                ->select("Type","name='ddlTable' ",array("Future Business Reward"=>"1","Family Business Reward"=>"2","Special Reward"=>"3"))
                ->confirmButton("confirm", "Report View", "index.php?option=com_mlm&task=closing_cont.displayList&format=raw")
                ->submit("View List");
        $data["form"]=$this->form->get();
        JRequest::setVar("layout","rewardlist");
        $this->load->view("reports.html",$data);
        $this->jq->getHeader();
    }
    function displayList(){
        //echo "in";
        $tableNo=$this->input->post("ddlTable");        
        if($tableNo==1)
        {
            $table="jos_xrewards";
            $reward = "Reward";
        }
        else if($tableNo==2)
        { 
            $table="jos_xspecialreward";
            $reward = "reward";
        }
        else
        {
            $table="jos_xbvreward";
            $reward = "reward";
        }
        $query="select jos_xpersonaldetails.`distributor_id` as did, jos_xpersonaldetails.`Name` as name, jos_xtreedetails.JoiningDate as jd, 
                $table.reward1 as r1 ,$table.reward2 as r2,$table.reward3 as r3,$table.reward4 as r4,$table.reward5 as r5,
                $table.reward6 as r6,$table.reward7 as r7,$table.reward8 as r8,$table.reward9 as r9,$table.reward10 as r10
                from jos_xtreedetails inner JOIN jos_xpersonaldetails 
                on jos_xtreedetails.id=jos_xpersonaldetails.distributor_id 
                inner join $table on jos_xtreedetails.id=$table.distributor_id 

                where ($table.reward1 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward2 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward3 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward4 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward5 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward6 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward7 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward8 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward9 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward10 BETWEEN '".$this->input->post('sdate')."'and '".$this->input->post('edate')."')
                
                "; 
        $rs=$this->db->query($query);
        $data["tableNo"]=$tableNo;
        $data['sdate']=$this->input->post('sdate');
        $data['edate']=$this->input->post('edate');
        $data["results"]=$rs->result();
        JRequest::setVar("layout","list1");
        $matter=$this->load->view("reports.html",$data);
        echo $matter;
    }
    function downloadList(){
        JRequest::setVar('layout', 'list1_xls');
        $tableNo=$this->input->post("ddlTable");        
        if($tableNo==1)
        {
            $table="jos_xrewards";
            $reward = "Reward";
        }
        else if($tableNo==2)
        { 
            $table="jos_xspecialreward";
            $reward = "reward";
        }
        else
        {
            $table="jos_xbvreward";
            $reward = "reward";
        }
        $query="select jos_xpersonaldetails.`distributor_id` as did, jos_xpersonaldetails.`Name` as name, jos_xtreedetails.JoiningDate as jd, 
                $table.reward1 as r1 ,$table.reward2 as r2,$table.reward3 as r3,$table.reward4 as r4,$table.reward5 as r5,
                $table.reward6 as r6,$table.reward7 as r7,$table.reward8 as r8,$table.reward9 as r9,$table.reward10 as r10
                from jos_xtreedetails inner JOIN jos_xpersonaldetails 
                on jos_xtreedetails.id=jos_xpersonaldetails.distributor_id 
                inner join $table on jos_xtreedetails.id=$table.distributor_id 

                where ($table.reward1 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward2 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward3 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward4 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward5 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward6 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward7 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward8 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward9 BETWEEN '".$this->input->post('sdate')."' and '".$this->input->post('edate')."'
                or $table.reward10 BETWEEN '".$this->input->post('sdate')."'and '".$this->input->post('edate')."')
                
                "; 
        $rs=$this->db->query($query);
        $data["tableNo"]=$tableNo;
        $data['sdate']=$this->input->post('sdate');
        $data['edate']=$this->input->post('edate');
        $data["results"]=$rs->result();
        $matter = $this->load->view('reports.xls', $data,true);
        $this->load->helper('download');
        $name = 'report.csv';
        force_download($name, $matter);
    }
}