<?php

class Model_PaymentReceivedVoucher extends Model_Voucher {

    function init() {
        parent::init();
        $this->voucher_type="RECEIPT";
        $this->default_narration="Received on date " .$this->api->recall('setdate',date('Y-m-d'));
    }

}