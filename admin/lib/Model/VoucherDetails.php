<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_VoucherDetails extends Model_Table {

    var $table = 'jos_xxvoucherdetails';

    function init() {
        parent::init();
        $this->hasOne('VoucherAll','voucher_id');
        $this->hasOne('Item','item_id');
        $this->addField('Rate');
        $this->addField('Qty');
        $this->addField('Amount');

    }

}