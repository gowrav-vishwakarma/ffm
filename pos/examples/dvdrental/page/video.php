<?php
class page_video extends Page {
    function init(){
        parent::init();
        $this->api->auth->check();

        $this->add('MVCGrid')->setModel('Movie');
    }
}
