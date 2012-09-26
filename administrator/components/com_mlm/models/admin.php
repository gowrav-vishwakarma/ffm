<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin extends DataMapper{
    var $table="xadmin";

    function getval($command){
        $this->where('Command',$command)->get();
        return $this->Values;
    }

    function setval($command,$value){
        $this->where('Command',$command)->get();
        $this->Values=$value;
        $this->save();
    }
}
?>