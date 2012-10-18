<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_JournalVoucher extends Model_Voucher {

    function init() {
        parent::init();
        $this->voucher_type="JV";
        $this->default_narration="JV on date " .$this->api->recall('setdate',date('Y-m-d'));
    }

}