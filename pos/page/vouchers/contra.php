<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class page_vouchers_contra extends page_voucher {

    function init() {
        parent::init();
        $v=$this->add('View_ContraVoucher');
    }

}