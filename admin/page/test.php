<?php
class page_test extends Page{
    function init(){
        parent::init();
        
        $maxNewJoining=$this->add('Model_Distributor');
        $max=$maxNewJoining->_dsql()->del('field')->field($maxNewJoining->dsql()->expr('MAX(ClosingNewJoining)'))->getOne();
        
        $this->add('Text')->set($max);
    }
}