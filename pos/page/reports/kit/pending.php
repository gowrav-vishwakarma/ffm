<?php
class page_reports_kit_pending extends Page {
	function page_index(){
		// parent::init();
		$grid=$this->add('Grid');
		$grid->setModel(
			$this->api->auth->model
				->ref('pos_id')
				->ref('ledger_id')
				->ref('MyKitsToGive')
				->addCondition('is_completed',false)
			);

		$grid->addColumn('Button','Send');

		if($_GET['Send']){
			$kit_transfer= $this->add('Model_KitTransfers');
			$kit_transfer->load($_GET['Send']);
			$kit_transfer['Transfered']=$kit_transfer['no_of_kits'];
			$kit_transfer['Transfered_on']=$this->api->recall('setdate',date('Y-m-d'));
			$kit_transfer['is_completed']=true;
			$kit_transfer->save();

			foreach($item=$kit_transfer->ref('kit_id')->ref('KitItems') as $junk){
				$pos=$this->add('Model_Pos');
				$pos->getCurrent();
				$pos->addStock($junk['id'],$junk['Qty']*-1);
			}

			$grid->js()->reload()->execute();
		}
	}

}