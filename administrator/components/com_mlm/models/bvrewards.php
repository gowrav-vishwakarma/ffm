<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Bvrewards extends DataMapper{
    var $table="xbvreward";
    var $has_one=array(
        "distributor" => array(
            "class" => "distributor",
            "join_other_as" => "distributor",
            "other_field" => "bvrewards",
            "join_table" => "jos_xbvrewards"
        )
    );

}
?>
