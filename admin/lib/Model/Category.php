<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Category extends Model_Table {

    var $table = 'jos_xxcategory';

    function init() {
        parent::init();
        $this->hasMany("Item", "category_id");
        $this->addField("name")->mandatory("Catagory Must have a Name")->caption("Category Name");
    }

}