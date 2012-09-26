<?php

class Model_ContraVoucher extends Model_Voucher {

    function init() {
        parent::init();
        $this->voucher_type="CONTRA";
        $this->default_narration="CONTRA on date " .date('Y-m-d');
    }

}