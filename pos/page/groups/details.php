<?php
class page_groups_details extends Page {
	function init(){
		parent::init();
		$this->api->stickyGET('group_id');
		$group=$this->add('Model_MyGroups');
		$group->tryLoad($_GET['group_id']);

		if($_GET['ledger_details']){
			$this->js()->univ()->redirect('ledgers_details',array('lid'=>$this->add('Model_VoucherEntry')->load($_GET['ledger_details'])->get('ledger_id')))->execute();	
		}

		if(!$group->loaded())
			$this->api->redirect('/');

		$this->add('H3')->set('Voucher Details for ' . $group['name'] . " from " . $this->api->recall('from_date') . " to " . $this->api->recall('to_date'));

		// SUB GROUP SUMS
		$this->add('H4')->set('Sub Groups Details Under ' . $group['name'] . " from " . $this->api->recall('from_date') . " to " . $this->api->recall('to_date'))->setStyle('color','lightblue');
		$sub_groups=$this->add('Model_MyGroups');
		$sub_groups->addCondition('lft','>',$group['lft']);
		$sub_groups->addCondition('rgt','<',$group['rgt']);

		foreach($sub_groups as $sg){
			$q=$this->api->db->dsql()
				->table('jos_xxvouchers')
				->join('jos_xxledgers','ledger_id',null,'l')
				->join('jos_xxgroups','l.group_id',null,'g')
				->join('jos_xxheads','g.head_id',null,'h')
				->field('SUM(AmountCR - AmountDR) Amount')
				->field('g.name group_name')
				->field('g.id group_id')
				// ->debug()
				->where('g.id',$sg['id'])
				->where('jos_xxvouchers.created_at','>=', $this->api->recall('from_date'))
				->where('jos_xxvouchers.created_at','<=', $this->api->recall('to_date'))
				->where('jos_xxvouchers.pos_id',$this->api->auth->model['pos_id'])
				// ->group('g.id')
				// ->having('Amount' ,'>=',0)
				;

			foreach($q as $junk){
				$v=$this->add('View',null,null,array('view/list/bookline'));
				$v->template->trySet('name',$junk['group_name']);
				$v->template->trySet('Amount',$junk['Amount']);
				$v->template->trySet('group_id',$junk['group_id']);
			}

		}
		// Ledgers Sums
		$this->add('H4')->set('Ledger Details Under ' . $group['name'] . " from " . $this->api->recall('from_date') . " to " . $this->api->recall('to_date'))->setStyle('color','lightblue');

		$q=$this->add('Model_Voucher');
		$lq=$q->join('jos_xxledgers','ledger_id',null,'l');
		$gq=$lq->join('jos_xxgroups','group_id',null,'g');
		$hq=$gq->join('jos_xxheads','head_id',null,'h');
			
		$q->addExpression('Amount_CR')->set('SUM(AmountCR)');
		$q->addExpression('Amount_DR')->set('SUM(AmountDR)');
		$lq->addField('ledger_name','name');
		// $quotemeta(str)->addField('ledger_id');
		// ->debug()
		$q->_dsql()->where('g.id',$group->id)
		->where('jos_xxvouchers.created_at','>=', $this->api->recall('from_date'))
		->where('jos_xxvouchers.created_at','<=', $this->api->recall('to_date'))
		->where('jos_xxvouchers.pos_id',$this->api->auth->model['pos_id'])
		->group('ledger_id')
		// ->having('Amount' ,'>=',0)
		;

		$grid=$this->add('Grid');
		$grid->setModel($q,array('ledger_name','Amount_CR','Amount_DR'));
		$grid->addPaginator(100);
		$grid->addQuickSearch(array('ledger_name','Amount_CR','Amount_DR'));
		$grid->addColumn('text','Amount_Current');
		$grid->addColumn('Button','ledger_details');

		$grid->addHook('formatRow',array($this,'formatGridRow'));
	}

	function formatGridRow($g){
		$cr=$g->current_row['Amount_CR'];
		$dr=$g->current_row['Amount_DR'];
		$g->current_row['Amount_Current']=abs($cr-$dr) . (($cr-$dr >= 0) ? " CR": " DR");
	}
}