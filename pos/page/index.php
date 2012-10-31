<?php

class page_index extends Page {
    function init(){
        parent::init();
        $v=$this->add('View')->set("initial");
        $btn1=$this->add('Button','btn1')->set('Btn1');     
        $btn2=$this->add('Button','btn2')->set('Btn2');

        if($btn1->isClicked("Do you want to continue..")){
        	$v->set('Ajaxed by btn1 '); // NOT HAPPENNING
        	$btn1->js()->univ()->alert("btn1 clicked")->execute();
        }

        if($btn2->isClicked("Do you want to continue..")){
        	$v->js()->reload(array("btn2_reload"=>1))->execute();
        }

        if($_GET['btn2_reload']){
        	$v->set('Ajaxed by btn2 '); // NOT HAPPENNING
        	$v->js()->univ()->alert("btn2 clicked")->execute(); // NOT HAPPENNING
        }
    }
}
