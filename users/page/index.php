<?php
class page_index extends Page {
    function init(){
        parent::init();
        	
        $cdv=$this->add('View_DistributorDetails');
        $cdv->id=$this->api->auth->model->id;
    }
}