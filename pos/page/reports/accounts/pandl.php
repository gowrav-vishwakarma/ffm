<?php
class page_reports_accounts_pandl extends page_reports {
	function init(){
		parent::init();
		
		$expense_sum=0;
		$income_sum=0;

		$from_date=$_GET['from_date'];
		$to_date=$_GET['to_date'];

		$this->api->memorize('from_date',$from_date);
		$this->api->memorize('to_date',$to_date);


		$heading=$this->add('H3')->set("P & L from $from_date to $to_date")->setAttr('align','center');
		$cols=$this->add('Columns');
		$expense_col=$cols->addColumn(6);
		$income_col=$cols->addColumn(6);

		$ex_head=$this->add('Model_Head');
		$ex_head->addCondition('id','in',array(10,14,11));

		$in_head=$this->add('Model_Head');
		$in_head->addCondition('id','in',array(12,15,13));

		foreach($ex_head as $junk){
			$expense_col->add('H3')->set($ex_head['name']);
			$q=$this->api->db->dsql()
				->table('jos_xxvouchers')
				->join('jos_xxledgers','ledger_id',null,'l')
				->join('jos_xxgroups','l.group_id',null,'g')
				->join('jos_xxheads','g.head_id',null,'h')
				->field('SUM(AmountDR - AmountCR) Amount')
				->field('g.name group_name')
				->field('g.id group_id')
				// ->debug()
				->where('h.id',$ex_head->id)
				->where('jos_xxvouchers.created_at','>=', $from_date)
				->where('jos_xxvouchers.created_at','<=', $to_date)
				->where('jos_xxvouchers.pos_id',$this->api->auth->model['pos_id'])
				->group('g.id')
				// ->having('Amount' ,'>',0)
				;

			foreach($q as $junk){
				$v=$expense_col->add('View',null,null,array('view/list/bookline'));
				$v->template->trySet('name',$junk['group_name']);
				$v->template->trySet('Amount',$junk['Amount']);
				$v->template->trySet('group_id',$junk['group_id']);
				$expense_sum += $junk['Amount'];
			}
		}

		foreach($in_head as $junk){
			$income_col->add('H3')->set($in_head['name']);
			$q=$this->api->db->dsql()
				->table('jos_xxvouchers')
				->join('jos_xxledgers','ledger_id',null,'l')
				->join('jos_xxgroups','l.group_id',null,'g')
				->join('jos_xxheads','g.head_id',null,'h')
				->field('SUM(AmountCR - AmountDR) Amount')
				->field('g.name group_name')
				->field('g.id group_id')
				// ->debug()
				->where('h.id',$in_head->id)
				->where('jos_xxvouchers.created_at','>=', $from_date)
				->where('jos_xxvouchers.created_at','<=', $to_date)
				->where('jos_xxvouchers.pos_id',$this->api->auth->model['pos_id'])
				->group('g.id')
				// ->having('Amount' ,'>=',0)
				;

			foreach($q as $junk){
				$v=$income_col->add('View',null,null,array('view/list/bookline'));
				$v->template->trySet('name',$junk['group_name']);
				$v->template->trySet('Amount',$junk['Amount']);
				$v->template->trySet('group_id',$junk['group_id']);
				$income_sum += $junk['Amount'];
			}
		}

		$ex_sum=$expense_col->add('View',null,null,array('view/list/bookline'));
		$ex_sum->template->trySetHTML('name','<b>Total</b>');
		$ex_sum->template->trySetHTML('Amount', "<b><i>".$expense_sum."</i></b>");
		$ex_sum->template->del('group_link');

		$in_sum=$income_col->add('View',null,null,array('view/list/bookline'));
		$in_sum->template->trySetHTML('name','<b>Total</b>');
		$in_sum->template->trySetHTML('Amount', "<b><i>".$income_sum."</i></b>");
		$in_sum->template->del('group_link');

		if($income_sum < $expense_sum){
			$profit=$income_col->add('View',null,null,array('view/list/bookline'));
			$profit->template->trySetHTML('name','<h2>Net Profit</h2>');
			$profit->template->trySetHTML('Amount', "<h2><b><i>".($expense_sum - $income_sum)."</i></b></h2>");
			$profit->template->trySet('Class','ui-widget-header');
			$profit->template->del('group_link');
		}else{
			$loss=$expense_col->add('View',null,null,array('view/list/bookline'));
			$loss->template->trySetHTML('name','<h2>Net Loss</h2>');
			$loss->template->trySetHTML('Amount', "<h2><b><i>".($income_sum - $expense_sum)."</i></b></h2>");
			$loss->template->trySet('Class','ui-widget-header');
			$loss->template->del('group_link');
		}


		if($_GET['group_details']){
			$this->js(true)->univ()->dialogURL("Details", $this->api->getDestinationURL('groups_details',array('group_id'=>$_GET['group_details'])));
		}

	}
}