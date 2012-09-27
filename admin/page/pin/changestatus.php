<?php
class page_pin_changestatus extends Page{
	function init(){
		parent::init();

		$form=$this->add('Form');
		$form->addField('line','from_id')->validateNotNull();
		$form->addField('line','to_id')->validateNotNull();
		$form->addField('dropdown','status')->setValueList(array(
															"-1"=>"Any",
															"1"=>"Published",
															"0"=>"Un-Published"
												))->set('-1');
		$form->addSubmit('Status Change');

		if($form->isSubmitted()){
			if($form->get('status')=="-1") $form->displayError('status',"Select any valid status to change");
			$m=$this->add('Model_Pin');
			$m->addCondition('id','>=',$form->get('from_id'));
			$m->addCondition('id','<=',$form->get('to_id'));
			$m->addCondition('Used',true);
			$m->tryLoadAny();
			if($m->loaded())
				$form->js()->univ()->errorMessage("The pins have used pin in between, cannot change status")->execute();

			$this->api->db->dsql()
				->table('jos_xpinmaster')
				->set('published',$form->get('status'))
				->where('id','>=',$form->get('from_id'))
				->where('id','<=',$form->get('to_id'))
				->update();
				$form->js(null,array(
						$form->js()->reload(),
						$form->js()->univ()->successMessage("Status changed")
					))->univ()->execute();
		}
				
	}
}