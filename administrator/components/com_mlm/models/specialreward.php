<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Specialreward extends DataMapper{
    var $table="xspecialreward";
    var $has_one=array(
        "distributor" => array(
            "class" => "distributor",
            "join_other_as" => "distributor",
            "other_field" => "specialrewards",
            "join_table" => "jos_xspecialrewards"
        )
    );

}
?>
