<?php
class View_Tree extends View{
	var $start_id;
	var $depth=5;
	function init(){
		parent::init();
	}

	function drawNode($parent_id,$id,$depth){
		if($depth == 0 ) return;

		$m=$this->add('Model_Distributor');
		$m->load($id);
		$clr=($m['TotalUpgradationDeduction'] + $m['ClosingUpgradationDeduction'] >= 8000) ? "folder_green.gif" : "folder_blue.gif";
		$this->js(true,"addNode($id,$parent_id,'".$m['name']." [".$m['inLeg']."]', '$clr')");
		if($m['left_id'] <> null)
			$this->drawNode($id,$m['left_id'],$depth-1);
		else if($depth-1 > 0)
			$this->js(true,"addNode(-${id}0001,$id,'A','question.gif')");

		if($m['right_id'] <> null)
			$this->drawNode($id,$m['right_id'],$depth-1);
		else if($depth-1 > 0)
			$this->js(true,"addNode(-${id}0002,$id,'B','question.gif')");

		$m->unload();
		$m->destroy();
	}

	function render(){
		// $this->js(true,"addNode(-1,0,'".$a['name']."')");
		$this->drawNode(-1,$this->start_id,$this->depth);
		$this->js(true,"displayTree()");
		
		$a=$this->add('Model_Distributor');
		$a->load($this->start_id);
		$this->template->trySet('sponsor_id',$a['sponsor_id']);

		parent::render();
	}

	function defaultTemplate(){
		return array('view/tree');
	}
}