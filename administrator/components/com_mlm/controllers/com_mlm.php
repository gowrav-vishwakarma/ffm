<?php

/* ------------------------------------------------------------------------
  # com_xcideveloper - Seamless merging of CI Development Style with Joomla CMS
  # ------------------------------------------------------------------------
  # author    Xavoc International / Gowrav Vishwakarma
  # copyright Copyright (C) 2011 xavoc.com. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
  # Websites: http://www.xavoc.com
  # Technical Support:  Forum - http://xavoc.com/index.php?option=com_discussions&view=index&Itemid=157
  ------------------------------------------------------------------------- */
// no direct access
defined('_JEXEC') or die('Restricted access');
?><?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class com_mlm extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        xMlmToolBars::getDefaultToolBar();
        $a = new Distributor();
        $this->load->library('session');
        $this->load->library('com_params');
//        $this->load->model('sample');
//        $data['result'] = $this->sample->getAll();
//        $data['params'] = $this->com_params->getGlobalParam('your_global_param');
        $this->load->library("form");
        $this->form->open("MyForm", "sdfsdf")
                ->setColumns(1)
                ->text("MyTest", "name='asd' class='input req-string'")
                ->text("MyTest", "name='asd' class='input req-string'")
                ->text("MyTest", "name='asd' class='input req-string'")
                ->text("MyTest", "name='asd' class='input req-string'")
//                            ->confirmButton("Confirm","Confirm Title","index.php?option=com_mlm&task=com_mlm.trys&format=raw",true)
                ->submit("sdf");
        $data['form'] = $this->form->get();

//        echo "<pre>";
//        print_r(JFactory::getUser());
//        echo "</pre>";

        
        $this->load->view('welcome.html', $data, false, true);
        $this->jq->getHeader();
        
//        $formParams = new JParameter('', '../config.xml');
//        $formParams->set('pure_ci', 1);
//        echo $formParams->render();

//        $c=new xConfig('Test');
////        $c->setkey('NoWhere',10);
//        echo "plan " . $c->getkey('RealyNo');
//        echo $c->_params->render();
//        echo "<pre>";
////        print_r($c->_params->renderToArray());
//        echo "</pre>";

//        $c->setkey('PlanHasIntroductionIncome',10);
//        $c->save();
//        global $com_params;
//        echo $com_params->get('aa');
        
    }

    function tryy(){
        echo '{ "title": { "text": "Area Chart" }, "elements": [ { "type": "area_hollow", "fill-alpha": 0.35, "values": [ 0, 0.377471728511, 0.739894850386, 1.07282069945, 1.36297657271, 1.59879487114, 1.77087426334, 1.87235448698, 1.89918984578, 1.85031049867, 1.72766511097, 1.53614316726, 1.28338004305, 0.979452606461, 0.636477485296, 0.268128015314, -0.110910872512, -0.485528093851, -0.84078884226, -1.16252999279, -1.43792474109, -1.65599396759, -1.80804394039, -1.8880129069, -1.89271275679, -1.82195612186, -1.67856384587, -1.46825252636, -1.19940661196, -0.882744140886, -0.530889446578 ], "width": 1 } ], "y_axis": { "min": -2, "max": 2, "steps": 2, "labels": null, "offset": 0 }, "x_axis": { "labels": { "steps": 4, "rotate": "vertical" }, "steps": 2 } }';
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */