<?php

class page_closing_details extends Page {

    function init() {
        parent::init();
        $this->api->stickyGET('filter');
        $this->api->stickyGET('distributor');
        $this->api->stickyGET('closing');

        $c = $this->add('Model_Closing');
        $c_q = $c->dsql();
        $c_q->del('field')->field($c->dsql()->expr('DISTINCT(closing) as name'))->order('id','desc');
        $c_a = array("Select Any Closing");
        foreach ($c_q as $c_name) {
            $c_a[] = $c_name['name'];
        }
        // print_r( $c_a);


        $form = $this->add('Form');
        $form->addField('autocomplete/basic', 'distributor')->setModel("Distributor");
        $form->addField('dropdown', 'closing')->setValueList($c_a);
        $form->addSubmit("Search");


        $m = $this->add('Model_Closing');

        if ($_GET['filter']) {
            if ($_GET['distributor'] != "") {
                $m->addCondition('distributor_id', $_GET['distributor']);
                $m->addCondition('ClosingAmount', '>', 0);
            }

            if ($_GET['closing'] != 0){
                $m->addCondition('closing', $c_a[$_GET['closing']]);
                $m->addCondition('ClosingAmountNet','>',0);
            }

            $m->_dsql()->order('id');
            // $m->debug();
        }else {
            $m->addCondition('distributor_id', '-1');
        }

        $grid = $this->add('Grid');
        $grid->setModel($m);
        $grid->add('misc/Export');
        $grid->addPaginator();

        if ($form->isSubmitted()) {
            $grid->js()->reload(array(
                "distributor" => $form->get('distributor'),
                "closing" => $form->get("closing"),
                "filter" => 1
            ))->execute();
        }
    }

}