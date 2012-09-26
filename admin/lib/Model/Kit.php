<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Kit extends Model_Table {

    var $table = 'jos_xkitmaster';

    function init() {
        parent::init();
        $this->addField('name','Name');
        
    }

}