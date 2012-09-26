<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Menu_AccountingVouchers extends Menu{
    function init() {
        parent::init();
        $this->addMenuItem('vouchers/dashboard',"DashBoard");
        $this->addMenuItem('vouchers/sales',"Sales vouchers");
        $this->addMenuItem('vouchers/purchase',"Purchase vouchers");
        $this->addMenuItem('vouchers/payment',"Payment");
        $this->addMenuItem('vouchers/receive',"Receipt");
        $this->addMenuItem('vouchers/jv',"Journal vouchers");
        $this->addMenuItem('vouchers/contra',"Contra Entry");
    }
}