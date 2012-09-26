<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Pin extends Model_Table {

    var $table = 'jos_xpinmaster';

    function init() {
        parent::init();
        $this->hasOne('Distributor','adcrd_id');
        $this->addField('Pin');
        $this->addField('Used')->type('boolean')->defaultValue(false);

        

    }

}