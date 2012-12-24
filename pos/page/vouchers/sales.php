<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class page_vouchers_sales extends page_voucher {

    function init() {
        parent::init();

        $tabs=$this->add("Tabs");
        $ds=$tabs->addTab("Distributor Sales");
        $cs=$tabs->addTab("Cash Sales");

        $dv=$ds->add("View_DistributorSalesVoucher","dsv");
        $gv=$cs->add("View_GuestSalesVoucher","gsp");
    }


}