<?php

class Model_PaymentReceivedVoucher extends Model_Voucher {

    function init() {
        parent::init();
        $this->voucher_type="PAYMENT";
        $this->default_narration="PAYMENT on date " .date('Y-m-d');
    }

}