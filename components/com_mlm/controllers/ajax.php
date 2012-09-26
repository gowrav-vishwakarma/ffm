<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ajax extends CI_Controller{
    function  __construct() {
        parent::__construct();
    }

    function sponsordetails(){
        echo $this->input->get('sponsorid')." welcome";
    }

     function distributorlist(){
        $d=new Details();
//        $user->alarm->where_join_field($user, 'wasfired', FALSE)->get();
        $list=array();
        $d->like('Name',inp("term"))->or_like('distributor_id',inp('term'))->limit(30)->get();
        foreach($d as $dd){
            $list[]=array('distributor_id'=>$dd->distributor_id,'Name'=>$dd->Name);
        }
//        $term=array(array('distributor_id'=>'11501','Name'=>'name1'));

        echo '{"tags":'. json_encode($list) .'}';
    }
}
?>
