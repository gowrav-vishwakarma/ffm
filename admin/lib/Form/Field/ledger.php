<?php

class Form_Field_Ledger extends autocomplete\Form_Field_plus {

    function init(){
        parent::init();
    }

    function setGroup($group, $includeSubGroups=true){
        $gm=$this->add('Model_GroupsAll');

        if(!is_array($group)) $group= array($group);
        
        $groups_id_array=array();

        // GET THE REQUIRED GROUP
        $gm->_dsql()->where('name', 'in', $group);
        foreach($gm as $junk){
            // $gm->tryLoadAny();
            $lft=$gm['lft'];
            $rgt=$gm['rgt'];
            // $gm->_dsql()->del('where');
            // $gm->unload();
            $n_gm=$this->add('Model_GroupsAll');
        	// GET ALL SUB GROUPS
        	$n_gm->addCondition('lft',">=",$lft);
        	$n_gm->addCondition('rgt',"<=",$rgt);

            $groups_id_array[] = $gm->id;

        	// GET ALL SUB GROUPS ID
        	if($includeSubGroups){
        		foreach($n_gm as $g)
        			$groups_id_array[]=$n_gm->id;
        	}
        }
    	// GET Ledgers of the groups
    	$lm=$this->add('Model_MyLedgers');
		$lm->_dsql()->where('group_id','in',$groups_id_array);
    	$this->setModel($lm);
    	return $this;
    }
}