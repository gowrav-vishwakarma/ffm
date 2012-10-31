<?php
class page_reports_accounts_balancesheet extends page_reports {
	function init(){
		parent::init();
		
		$expense_sum=0;
		$income_sum=0;

		$from_date=$_GET['from_date'];
		$to_date=$_GET['to_date'];

		$this->api->memorize('from_date',$from_date);
		$this->api->memorize('to_date',$to_date);


		$heading=$this->add('H3')->set("Balance Sheet from $from_date to $to_date")->setAttr('align','center');
		$cols=$this->add('Columns');
		$left_col=$cols->addColumn(6);
		$right_col=$cols->addColumn(6);

		$left_head=$this->add('Model_Head');
		$left_head->addCondition('id','in',array(1,2,3,4,5));

		$right_head=$this->add('Model_Head');
		$right_head->addCondition('id','in',array(6,7,8,9));

		foreach($left_head as $junk){
			$left_col->add('H3')->set($left_head['name']);
			$q=$this->api->db->dsql()
				->table('jos_xxvouchers')
				->join('jos_xxledgers','ledger_id',null,'l')
				->join('jos_xxgroups','l.group_id',null,'g')
				->join('jos_xxheads','g.head_id',null,'h')
				->field('SUM(AmountDR - AmountCR) Amount')
				->field('g.name group_name')
				->field('g.id group_id')
				// ->debug()
				->where('h.id',$left_head->id)
				->where('jos_xxvouchers.created_at','>=', $from_date)
				->where('jos_xxvouchers.created_at','<=', $to_date)
				->where('jos_xxvouchers.pos_id',$this->api->auth->model['pos_id'])
				->group('g.id')
				// ->having('Amount' ,'>=',0)
				;

			foreach($q as $junk){
				if($junk['Amount'] < 0){
					$v=$right_col->add('View',null,null,array('view/list/bookline'));
					$income_sum += abs($junk['Amount']);
				}
				else{
					$v=$left_col->add('View',null,null,array('view/list/bookline'));
					$expense_sum += $junk['Amount'];
				}
				$v->template->trySet('name',$junk['group_name']);
				$v->template->trySet('Amount',abs($junk['Amount']));
				$v->template->trySet('group_id',$junk['group_id']);
			}
		}

		foreach($right_head as $junk){
			$right_col->add('H3')->set($right_head['name']);
			$q=$this->api->db->dsql()
				->table('jos_xxvouchers')
				->join('jos_xxledgers','ledger_id',null,'l')
				->join('jos_xxgroups','l.group_id',null,'g')
				->join('jos_xxheads','g.head_id',null,'h')
				->field('SUM(AmountCR - AmountDR) Amount')
				->field('g.name group_name')
				->field('g.id group_id')
				// ->debug()
				->where('h.id',$right_head->id)
				->where('jos_xxvouchers.created_at','>=', $from_date)
				->where('jos_xxvouchers.created_at','<=', $to_date)
				->where('jos_xxvouchers.pos_id',$this->api->auth->model['pos_id'])
				->group('g.id')
				// ->having('Amount' ,'>=',0)
				;

			foreach($q as $junk){
				if($junk['Amount'] < 0 ){
					$v=$left_col->add('View',null,null,array('view/list/bookline'));
					$expense_sum += abs($junk['Amount']);
				}
				else{
					$v=$right_col->add('View',null,null,array('view/list/bookline'));
					$income_sum += $junk['Amount'];
				}
				$v->template->trySet('name',$junk['group_name']);
				$v->template->trySet('Amount',abs($junk['Amount']));
				$v->template->trySet('group_id',$junk['group_id']);
			}
		}

		if($income_sum > $expense_sum){
			$profit=$left_col->add('View',null,null,array('view/list/bookline'));
			$profit->template->trySetHTML('name','Net Profit');
			$profit->template->trySetHTML('Amount', "<b><i>".($pandl= $income_sum - $expense_sum)."</i></b>");
			$profit->template->del('group_link');
			// $profit->template->trySet('Class','ui-widget-header');
		}else{
			$loss=$right_col->add('View',null,null,array('view/list/bookline'));
			$loss->template->trySetHTML('name','Net Loss');
			$loss->template->trySetHTML('Amount', "<b><i>".($pandl = $expense_sum - $income_sum)."</i></b>");
			$loss->template->del('group_link');
			// $loss->template->trySet('Class','ui-widget-header');
		}

		$ex_sum=$left_col->add('View',null,null,array('view/list/bookline'));
		$ex_sum->template->trySetHTML('name','<b>Total</b>');
		$ex_sum->template->trySetHTML('Amount', "<b><i>".($income_sum > $expense_sum ? $expense_sum + $pandl : $expense_sum	) ."</i></b>");
		$ex_sum->template->del('group_link');

		$in_sum=$right_col->add('View',null,null,array('view/list/bookline'));
		$in_sum->template->trySetHTML('name','<b>Total</b>');
		$in_sum->template->trySetHTML('Amount', "<b><i>". ($income_sum < $expense_sum ? $income_sum + $pandl : $income_sum ) ."</i></b>");
		$in_sum->template->del('group_link');



		if($_GET['group_details']){
			$this->js(true)->univ()->dialogURL("Details", $this->api->getDestinationURL('groups_details',array('group_id'=>$_GET['group_details'])));
		}

	}
}