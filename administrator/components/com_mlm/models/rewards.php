<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Rewards extends DataMapper {

    var $table = "xrewards";
    
    var $has_one = array(
        "distributor" => array(
            "class" => "distributor",
            "join_other_as" => "distributor",
            "other_field" => "rewards",
            "join_table" => "jos_xrewards"
        )
    );


}

?>