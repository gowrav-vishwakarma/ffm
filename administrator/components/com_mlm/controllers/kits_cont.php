<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class kits_cont extends CI_Controller{
    function __construct(){
        parent::__construct();
    }

    function dashboard(){
        xMlmToolBars::KitManagementToolBar();
        $k=new kit();
        $k->get();
        $data["kits"]=$k;
        $this->load->view("kits.html",$data);
        $this->jq->getHeader();
    }

    function edit(){
        $id=$this->input->get("kitid");
        $k=new Kit($id);
        $this->load->library("form");
        $this->form->open("formedit","index.php?option=com_mlm&task=kits_cont.updatekit")
                ->text("Kit Name","name='kitname' class='input req-string' value='$k->Name'")
                ->text("MRP","name='MRP' class='input req-numeric' value='$k->MRP'")
                ->text("DP","name='DP' class='input req-numeric' value='$k->DP'")
                ->text("Introduction Amount","name='IntroductionAmount' class='input req-numeric' value='$k->AmountToIntroducer'")
                ->text("BV","name='BV' class='input req-numeric' value='$k->BV'")
                ->text("PV","name='PV' class='input req-numeric' value='$k->PV'")
                ->text("RP","name='RP' class='input req-numeric' value='$k->RP'")
                ->text("Capping","name='Capping' class='input req-numeric' value='$k->Capping'")
                ->Select("Green Pin","name='Green' class='input req-numeric'",array("Green"=>'1',"Red"=>'0'),$k->DefaultGreen)
                ->Select("Published","name='published' class='input req-numeric'",array("Published"=>'1',"UnPublished"=>'0'),$k->published)
                ->hidden("","name='id' value='$k->id'")
                ->submit("Update");
        echo $this->form->get();
        $this->jq->getHeader(true);
    }

    function updatekit(){
        $x=inp("id");
        $k=new Kit($x);
        $k->Name=inp('kitname');
        $k->MRP=inp("MRP");
        $k->DP=inp("DP");
        $k->AmountToIntroducer=inp("IntroductionAmount");
        $k->BV=inp("BV");
        $k->PV=inp("PV");
        $k->RP=inp("RP");
        $k->Capping=inp("Capping");
        $k->DefaultGreen=inp("Green");
        $k->published=inp("published");
        if($k->save()){
                $msg="Kit Edited Successfully";
                $type="info";
        }
        else{
            $msg = "Kit Was not Edited";
            $type="error";
        }
        xRedirect("index.php?option=com_mlm&task=kits_cont.dashboard",$msg,$type);
    }

    function addnewform(){
        xMlmToolBars::addKitToolBar();
        $this->load->library("form");
        $this->form->open("adminFormz","index.php?option=com_mlm&task=kits_cont.addkit")
                ->text("Kit Name","name='kitname' class='input req-string' emsg='Give a Kit Name PLease'")
                ->text("MRP","name='MRP' class='input req-string req-numeric'")
                ->text("DP","name='DP' class='input req-string req-numeric'")
                ->text("Introduction Amount","name='IntroductionAmount' class='input req-string req-numeric'")
                ->text("BV","name='BV' class='input req-string req-numeric'")
                ->text("PV","name='PV' class='input req-string req-numeric'")
                ->text("RP","name='RP' class='input req-string req-numeric'")
                ->text("Capping","name='Capping' class='input req-string req-numeric'")
                ->Select("Green Pin","name='Green' class='input req-numeric'",array("Green"=>'1',"Red"=>'0'))
                ->Select("Published","name='published' class='input req-numeric'",array("Published"=>'1',"UnPublished"=>'0'))
                ->_()
                ->submit("Create");
        $data['form']= $this->form->get();
        JRequest::setVar('layout','newkitform');
        $this->load->view('kits.html',$data);
        $this->jq->getHeader();
    }

    function addkit(){
        $k=new Kit();
        $k->Name=inp('kitname');
        $k->MRP=inp("MRP");
        $k->DP=inp("DP");
        $k->AmountToIntroducer=inp("IntroductionAmount");
        $k->BV=inp("BV");
        $k->PV=inp("PV");
        $k->RP=inp("RP");
        $k->Capping=inp("Capping");
        $k->DefaultGreen=inp("Green");
        $k->published=inp("published");
        if($k->save()){
                $msg="Kit Added Successfully";
                $type="info";
        }
        else{
            $msg = "Kit Was not Added";
            $type="error";
        }
        xRedirect("index.php?option=com_mlm&task=kits_cont.dashboard",$msg,$type);
    }

    function kitWiseGraphData(){
        $this->load->library('ofc2');
        $startdate=($this->input->get('startdate')=='')? "1970-01-01" : $this->input->get('startdate');
        $enddate=($this->input->get('enddate')=='')? getNow('Y-m-d') : $this->input->get('enddate');

        $q="SELECT t.kit_id as ID, k.Name ForKit, count(*) as Joinings from (SELECT kit_id, JoiningDate from jos_xtreedetails where JoiningDate between '$startdate' and '$enddate') t inner join jos_xkitmaster k on t.kit_id=k.id
            GROUP BY t.kit_id";
        $r=$this->db->query($q)->result();
        $vals=array();
        foreach($r as $rr){
            $vals[] = new pie_value((int)$rr->Joinings, $rr->ForKit);
        }
//        echo "<pre>";
//        print_r($vals);
//        echo "</pre>";
        $period=($startdate == "1970-01-01")? "":"From $startdate and $enddate";
        $title = new title( "Kit Wise Total Joinings " . $period );
        $pie = new pie();
        $pie->set_alpha(0.6);
        $pie->set_start_angle( 35 );
        $pie->add_animation( new pie_fade() );
        $pie->add_animation(new pie_bounce(15));
        $pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
        $pie->set_colours( array('#1C9E05','#FF368D') );
//        $pie->set_values( array(new pie_value(6.5, "hello (6.5)"),2,3,4) );
        $pie->set_values($vals);

        $chart = new open_flash_chart();
        $chart->set_title( $title );
        $chart->add_element( $pie );


        $chart->x_axis = null;

        echo $chart->toPrettyString();
    }
    function formReport(){
        xMlmToolBars::formKitToolBar();
        $this->load->library("form");
        $this->form->open("report","index.php?option=com_mlm&task=kits_cont.showKitReport")
            ->dateBox("From Date","name='fDate' class='input req-string'")
            ->dateBox("To Date","name='tDate' class='input req-string'")
            ->submit("Show");
        $data['form']= $this->form->get();
        JRequest::setVar('layout','formkitreport');
        $this->load->view('kits.html',$data);
        $this->jq->getHeader();
    }

    function showKitReport(){
        //xMlmToolBars::showReportKitToolBar();
        $this->formReport();
        $startdate=$this->input->post("fDate");
        $enddate=$this->input->post("tDate");
        $data["start"]=$startdate;
        $data["end"]=$enddate;
        $q="SELECT t.kit_id as ID, k.Name ForKit, count(*) as Joinings from (SELECT kit_id, JoiningDate from jos_xtreedetails where JoiningDate between '$startdate' and '$enddate') t inner join jos_xkitmaster k on t.kit_id=k.id
            GROUP BY t.kit_id";
        $r=$this->db->query($q)->result();
        $data["result"]=$r;
        JRequest::setVar('layout','showkitreport');
        $this->load->view('kits.html',$data);
        $this->jq->getHeader();
    }
}
?>