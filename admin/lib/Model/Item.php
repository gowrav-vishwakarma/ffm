<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Item extends Model_Table {

    var $table = 'jos_xxitems';

    function init() {
        parent::init();
        $this->hasOne("Category","category_id");
        $this->hasMany("Stock","item_id");
        $this->hasMany("VoucherDetails","item_id");
        $this->hasMany("MyVoucherDetails","item_id");
        
        $this->addField("name")->mandatory("Item must have a Name")->caption('Item Name');
//        $this->addField("PurchasePrice");
//        $this->addField("LastPurchasePrice");
        $this->addField("DealerPrice");
        $this->addField("RetailerPrice");
        // $this->addField("PV");
        $this->addField("BV");
        // $this->addField("RP");
        $this->addField("DP");
        $this->addField("MRP");
        $this->addField("Unit");
        
        
    }

}