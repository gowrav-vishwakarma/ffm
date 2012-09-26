<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Kit extends DataMapper{
    var $table = "xkitmaster";
    var $has_many = array(
        "distributors"=>array(
            "class"=>"distributor",
            "join_self_as"=>"kit",
            "other_field"=>"kit",
            "join_table"=>"jos_xtreedetails"
        ),
        "pins"=>array(
            "class"=>"pin",
            "join_self_as"=>"kit",
            "other_field"=>"kit",
            "join_table"=>"jos_xpinmaster"
        )
    );

    function getKitList($forselect=false){
        $this->where('published',1)->get();
        $list=array();
        if($forselect)
            $list += array("Select Kit"=>"-1");

        foreach($this as $k){
            $list += array($k->Name => $k->id);
        }
        return $list;
    }
}
?>
