<?php

class Model_CommissionVoucher extends Model_Voucher {

    function init() {
        parent::init();
        $this->voucher_type="COMMISSION";
        $this->default_narration="COMMISSION DUE on date " .$this->api->recall('setdate',date('Y-m-d'));
    }

}