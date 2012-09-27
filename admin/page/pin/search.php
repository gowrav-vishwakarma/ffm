<?php
class page_pin_search extends Page{
	function init(){
		parent::init();

		$form=$this->add('Form');

		$grid=$this->add('Grid');
		$k=$this->add('Model_Pin');
		// $k->_dsql()->limit(10);

		if($_GET['selected']){
			
			if($_GET['from_dist']!='')	$k->addCondition('id','>=',$_GET['from_dist']);
			if($_GET['to_dist']!='')	$k->addCondition('id','<=',$_GET['to_dist']);
			if($_GET['for_kit']!='')	$k->addCondition('kit_id',$_GET['for_kit']);
			if($_GET['published_status']!='-1')	$k->addCondition('published',$_GET['published_status']);
			if($_GET['used_status']!='-1')	$k->addCondition('Used',$_GET['used_status']);

		}

		$grid->setModel($k);
		$grid->addPaginator(10);

		$form->addField('line','from_disrtibutor');
		$form->addField('line','to_distributor');
		$form->addField('dropdown','for_kit')->setEmptyText("Any Kit")->setModel('Kit');
		$form->addField('dropdown','published_status')->setValueList(array(
														"-1"=>"Any",
														"0"=>"Unpublished",
														"1"=>"Published"
															))->set('-1');	
		$form->addField('dropdown','used_status')->setValueList(array(
															"-1"=>"Any",
															"1"=>"Used",
															"0"=>"Un-Used"	
															))->set('-1');
		$form->addSubmit('Search');

		if($form->isSubmitted()){
			$grid->js()->reload(array(
							'from_dist'=>$form->get('from_disrtibutor'),
							'to_dist'=>$form->get('to_distributor'),
							'for_kit'=>$form->get('for_kit'),
							'published_status'=>$form->get('published_status'),
							'used_status'=>$form->get('used_status'),
							'selected'=>'1',
							))->execute();
		}
	}
}