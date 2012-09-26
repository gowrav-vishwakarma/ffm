<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class survey_cont extends CI_Controller{
    function __construct(){
        parent::__construct();
    }

    function index(){
        xMlmToolBars::surveyManagementToolBar();
        $s=new Survey();
        $s->get();
        $data['surveys']=$s;
        $this->load->view("surveys.html",$data);
    }

    function addSurveyForm(){
        xMlmToolBars::cancleDefault("Add a new Survey Here","survey_cont.index");
        $c = new xConfig('survey_config');
        $this->load->library("form");
        JRequest::setVar("layout","addSurvey_".$c->getKey("SurveyType"));
        $this->load->view("surveys.html");
        $this->jq->getHeader();
    }

    function addSurvey(){
        $s= new Survey();
        $s->Title=$this->input->post("title");
        $s->Survey=$this->input->post("survey");
        $s->A=$this->input->post("A");
        $s->B=$this->input->post("B");
        $s->C=$this->input->post("C");
        $s->D=$this->input->post("D");
        $s->Correct=$this->input->post("Correct");
        $s->Points=$this->input->post("Points");
        $s->StartDate=$this->input->post("startdate");
        $s->EndDate=$this->input->post("enddate");
        $s->Type=$this->input->post("Type");
        $s->save();
        xRedirect("index.php?option=com_mlm&task=survey_cont.index","Survey Saved");
    }

}
?>