<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Survey extends DataMapper{
    var $table='xsurveys';

    var  $has_many=array(
        'doneby'=>array(
            'class'=>'distributorsurveys',
            'join_self_as'=>'survey',
            'join_other_as'=>'distributor',
            'other_field'=>'donesurveys',
            'join_table'=>'jos_xsurvey_done'
        )
    );
}
?>