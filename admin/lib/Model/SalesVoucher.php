<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_SalesVoucher extends Model_Voucher {

    function init() {
        parent::init();
        $this->voucher_type="SALES";
        $this->default_narration="SALE on date " .date('Y-m-d');
    }

}