<?php

class Model_PaymentVoucher extends Model_Voucher {

    function init() {
        parent::init();
        $this->voucher_type="PAYMENT";
        $this->default_narration="PAYMENT on date " .$this->api->recall('setdate',date('Y-m-d'));
    }

}