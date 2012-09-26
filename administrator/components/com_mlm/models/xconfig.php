<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class xConfig extends DataMapper {

    var $table = 'xconfig';
    var $_params;

    function __construct($title){
        parent::__construct();
        $this->where('Title', $title)->get();
        $this->_params = new JParameter($this->params,'components/com_mlm/config/'.$title.".xml");
        $this->Title=$title;
    }

    function getkey($key,$fromsave=false){
        $x=$this->_params->get($key);
        if($x==''){
            $temp=$this->_params->renderToArray();
            if(isset($temp[$key])){
                $this->setkey($key,$temp[$key][4]);
                if($fromsave) return;
                $this->save();
                return $temp[$key][4]; // 4 number is for default value
            }
        }
         
        return $x;
    }

    function setkey($key, $value) {
        $this->_params->set($key, $value);
    }

    function save() {
        $temp=$this->_params->renderToArray();
        $this->params='';
        foreach($temp as $key=>$values){
            $this->params .= ($key ."=".$this->getkey($key,true)."\n");
        }
        parent::save();
    }

    function render(){
        return $this->_params->render('params');
    }

}

?>