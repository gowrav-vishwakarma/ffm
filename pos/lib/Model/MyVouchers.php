<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_MyVouchers extends Model_Voucher{
    function init() {
        parent::init();
        $this->addCondition('pos_id',$this->api->auth->model['pos_id']);
    }
}