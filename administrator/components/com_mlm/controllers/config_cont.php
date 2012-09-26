<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class config_cont extends CI_Controller{
    function  __construct() {
        parent::__construct();
        $u=JFactory::getUser();
        if($u->usertype != "Super Administrator"){
            xRedirect("index.php?option=com_mlm&task=com_mlm.index","You are not Authorised to Configure the system","error");
        }
    }

    function index(){
        xMlmToolBars::configToolBar();
        $this->load->view('config.html');
        $this->jq->getHeader();
    }

    function edit(){
        xMlmToolBars::configEditToolBar($this->input->get("config"));
        $c=new xConfig($this->input->get("config"));

        $data['configFile']=$this->input->get("config");
        $data['config']=$c;

        JRequest::setVar("layout","edit");
        $this->load->view('config.html',$data);
    }
    
    function saveConfig(){
        if($this->input->post("task")=="config_cont.index")
                xRedirect("index.php?option=com_mlm&task=config_cont.index","Back To Configuration Dashboard");
        $config=$this->input->post('config');
        $c=new xConfig($config);
        $params=$this->input->post('params');
        foreach($params as $key=>$value)
            $c->setkey($key,$value);
        $c->save();
        xRedirect("index.php?option=com_mlm&task=config_cont.index","Configuration Saved");
    }

}
?>
