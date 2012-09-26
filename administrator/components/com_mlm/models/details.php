<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Details extends DataMapper {

    var $table = "xpersonaldetails";
    var $has_one = array(
        "detailsof" => array(
            "class" => "distributor",
            "join_other_as" => "distributor",
            "other_field" => "detail",
            "join_table" => "jos_xpersonaldetails"
        )
    );
    var $validation = array(
        'Address' => array(
            'label' => 'Address',
            'rules'=>array(),
            'get_rules' => array('getfulladdress')
        )
    );

    function _getfulladdress($field) {
        $this->$field = $this->Address . ", " . $this->City;
    }

}

?>
