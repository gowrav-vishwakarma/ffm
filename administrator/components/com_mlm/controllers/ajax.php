<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Ajax extends CI_Controller{
    function  __construct() {
        parent::__construct();
    }

    function distributorlist(){
        $d=new Details();
//        $user->alarm->where_join_field($user, 'wasfired', FALSE)->get();
        $list=array();
        $d->like('Name',inp("term"))->or_like('distributor_id',inp('term'))->limit(50)->get();
        foreach($d as $dd){
            $list[]=array('distributor_id'=>$dd->distributor_id,'Name'=>$dd->Name,"SponsorID"=>"Current Sponsor " . $dd->detailsof->sponsor_id);
        }
//        $term=array(array('distributor_id'=>'11501','Name'=>'name1'));
        
        echo '{"tags":'. json_encode($list) .'}';
    }

    function getMainClsoingsNames(){
        $mc = new xMainClosing();
        $mc->select('closing')->distinct()->like('closing',inp('term'))->get();
        $list=array();
        foreach($mc as $dd){
            $list[]=array('closing'=>$dd->closing);
        }
        echo '{"tags":'. json_encode($list) .'}';
    }
    function distributorNO(){
        $d=new Details();
//        $user->alarm->where_join_field($user, 'wasfired', FALSE)->get();
        $list=array();
        $d->like('Name',inp("term"))->or_like('MobileNo',inp('term'))->get();
        foreach($d as $dd){
            $list[]=array('Mobile'=>$dd->MobileNo,'Name'=>$dd->Name);
        }
//        $term=array(array('distributor_id'=>'11501','Name'=>'name1'));

        echo '{"tags":'. json_encode($list) .'}';
    }

}
?>
