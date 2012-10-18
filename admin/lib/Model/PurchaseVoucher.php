<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_PurchaseVoucher extends Model_Voucher {

    function init() {
        parent::init();
        $this->voucher_type="PURCHASE";
        $this->default_narration="PURCHASED on date " .$this->api->recall('setdate',date('Y-m-d'));
    }

}