<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class DistributorSurveys extends DataMapper{
    var $table='xsurvey_done';
    var $has_one=array(
        'survey'=>array(
            'class'=>'survey',
            'join_other_as'=>'survey',
            'other_field'=>'doneby',
            'join_table'=>'jos_xsurvey_done'
        ),
        'distributor'=>array(
            'class'=>'distributor',
            'join_other_as'=>'distributor',
            'other_field'=>'donesurveys',
            'join_table'=>'jos_xsurvey_done'
        )
    );
}
?>