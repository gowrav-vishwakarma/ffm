<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_GroupsAll extends Model_Table {

    var $table = 'jos_xxgroups';

    function init() {
        parent::init();
        $this->hasOne("Head", "head_id"); //->system(true);
        $this->hasOne('GroupsAll', 'group_id')->caption("Parent Group");
        $this->hasOne('Pos', 'pos_id')->system(true);
        $this->hasMany('SubGroup', 'group_id');
        $this->addField('name')->mandatory("Group must have a Name");
        $this->addField("Path")->system(true);
        $this->addField("lft")->system(true);
        $this->addField("rgt")->system(true);
        $this->hasMany('Ledger', 'group_id');

        $this->addHook('beforeSave', $this);
        $this->addHook('beforeDelete', $this);
    }

    function beforeSave() {

//        MANAGE HIRARCHY
        $parent_group = $this->ref('group_id');
        if (!$parent_group->loaded()) {
            $parent_group = $this->add('Model_GroupsAll');
            $parent_group->addCondition('lft', 0);
            $parent_group->loadAny();
        }

        $this['lft'] = $parent_group['rgt'];
        $this['rgt'] = $this['lft'] + 1;

        $this->api->db->dsql()->table('jos_xxgroups')->set('rgt', $this->api->db->dsql()->expr('rgt+2'))->where($this->api->db->dsql()->expr('rgt >= ' . $parent_group['rgt']))->do_update();
        $this->api->db->dsql()->table('jos_xxgroups')->set('lft', $this->api->db->dsql()->expr('lft+2'))->where($this->api->db->dsql()->expr('lft >= ' . $parent_group['rgt']))->do_update();
    }
    
    function beforeDelete(){
        if($this['lft']==0) throw $this->exception("You cannot delete root group");
    }

    function getGroupID($groupName){
        $m=$this->add('Model_GroupsaLL');
        $m->addCondition('name',$groupName);
        $m->tryLoadAny();
        if($m->loaded()) return $m->id;
        return false;
    }

}