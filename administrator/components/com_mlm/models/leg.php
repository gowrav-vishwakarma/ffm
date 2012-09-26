<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Leg extends DataMapper{
    var $table="xlegs";
     var $default_order_by = array('Leg');
    var $has_one=array(
        "under"=>array(
            "class"=>"leg",
            "join_other_as"=>"distributor",
            "other_field"=>"legs",
            "join_table"=>"jos_xlegs"
        )
    );
}
?>
