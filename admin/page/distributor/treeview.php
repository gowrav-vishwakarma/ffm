<?php
class page_distributor_treeview  extends Page{
    function init(){
        parent::init();
        
        $e=$this->add('View_Error');
        $showerror=false;

        $tv=$this->add('View_Tree');
        if($_GET['Start']){
            $wanted_id=$this->add('Model_Distributor');
            $wanted_id->tryLoad($_GET['Start']);
            if( !$wanted_id->loaded() /*OR strpos($wanted_id['Path'],$this->api->auth->model['Path'] -- admin not needed to check for only downline view) === false */){
                $e->set("The required Id is either not present or not in your down");
                $showerror=true;
                $tv->start_id = 1;
            }
            else
                $tv->start_id = $_GET['Start'];
        }
        else
            $tv->start_id = 1;
    
        if(!$showerror){
            $e->js(true)->hide();
        }
        
    }

}