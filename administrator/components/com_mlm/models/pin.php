<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Pin extends DataMapper {

    var $table = "xpinmaster";
    var $has_one = array(
        "distributor" => array(
            "class" => "distributor",
            "join_self_as" => "pin",
            "other_field" => "pin",
            "join_table" => "jos_xtreedetails"
        ),
        "adcrd" => array(
            "class" => "distributor",
            "join_self_as" => "adcrd",
            "other_field" => "pinsinaccount",
            "join_table" => "jos_xtreedetails"
        ),
        "kit" => array(
            "class" => "kit",
            "join_other_as" => "kit",
            "other_field" => "pins",
            "join_table" => "jos_xpinmaster"
        )
    );

    function generatePins($adc_rd_no, $forkit, $noofpins,$PublishStatus) {
        $k = new Kit();
        $k->get_by_id($forkit);

        for ($i = 1; $i <= $noofpins; $i++) {
            $newpin = $this->uuid();
            do {
                $p = new Pin();
                $p->where('Pin', $newpin)->get();
            } while ($p->result_count() > 0);
            
            $p = new Pin();
            $p->Pin = $newpin;
            $p->kit_id = $k->id;
            $p->BV = $k->BV;
            $p->PV=$k->PV;
            $p->RP=$k->RP;
            $p->Used = 0;
            $p->adcrd_id = $adc_rd_no;
            $p->published=$PublishStatus;
            $p->save();
            if($i==1)
                $startID=$p->id;
            if($i==$noofpins)
                $endID=$p->id;
        }
        
        return array("StartID" => $startID, "EndID" => $endID);
    }

    function uuid() {
        // The field names refer to RFC 4122 section 4.1.2

        return sprintf('%04x-%04x-%04x-%04x',
                mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
                mt_rand(0, 65535), // 16 bits for "time_mid"
                mt_rand(0, 4095), // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
                bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
                // 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
                // (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
                // 8 bits for "clk_seq_low"
                mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node"
        );
    }

    function checkpin(){
        if($this->Used==1 or $this->published==0)
                return false;
        return true;
    }

}

?>
