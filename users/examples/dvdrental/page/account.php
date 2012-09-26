<?php
class page_account extends Page {
    function init(){
        parent::init();
        
        $this->api->auth->check();

        $model = $this->add('Model_Customer');
        $model->getField('email')->system(true);
        $this->add('FormAndSave')->setModel($model)->loadData($this->api->auth->get('id'));
    }
}
