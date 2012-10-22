<?php
class page_vouchers_edit extends Page {
	function init(){
		parent::init();
		$this->api->stickyGET('voucher_id');
		$this->add('Text')->set($_GET['voucher_id']);

		$ve=$this->add('Model_VoucherEntry');
		$ve->load($_GET['voucher_id']);

		$v=$this->add('Model_VoucherAll');
		$v->addCondition('pos_id',$ve['pos_id']);
		$v->addCondition('VoucherType',$ve['VoucherType']);
		$v->addCondition('VoucherNo',$ve['VoucherNo']);

		$form=$this->add('Form');
		$form->addClass('atk-row');
		$form->template->trySet('fieldset','atk-row');
		// $cols=$form->add('Columns');
		// $lc=$cols->addColumn('span6');
		// $rc=$cols->addColumn('span6');
		$i=1;
		foreach($v as $junk){
			$form->addField('hidden','voucher_id_'.$i)->set($v->id);
			$form->addField('readonly','ledger_'.$i)->set($v['ledger'] . " - " . $v['entry_side']);
			if($v['AmountDR'] != 0){
				$form->addField('line','dr_amount_'.$i)->set($v['AmountDR']);
				$form->addField('hidden','cr_amount_'.$i)->set(0);
			}
			else{
				$form->addField('line','cr_amount_'.$i)->set($v['AmountCR']);
				$form->addField('hidden','dr_amount_'.$i)->set(0);
			}

			$i++;
		}
		$form->addField('hidden','no_of_rows')->set($i-1);
		$form->addField('text', 'Narration')->set($ve['Narration']);
		$form->addField('DatePicker','voucher_date')->set($ve['created_at']);
		$form->addSubmit('Update');

		if($form->isSubmitted()){
			$cr_sum=0;
			$dr_sum=0;
			for($i=1;$i<=$form->get('no_of_rows');$i++){
				$dr_sum += $form->get('dr_amount_'.$i);
				$cr_sum += $form->get('cr_amount_'.$i);
			}
			if($dr_sum != $cr_sum) $form->js()->univ()->errorMessage("Debit and Credit Side are not same")->execute();
			
			$ve=$this->add('Model_VoucherEntry');
			for($i=1;$i<=$form->get('no_of_rows');$i++){
				$ve->load($form->get('voucher_id_'.$i));
				$ve['AmountDR']=$form->get('dr_amount_'.$i);
				$ve['AmountCR']=$form->get('cr_amount_'.$i);
				$ve['Narration']=$form->get('Narration');
				$ve['created_at']=$form->get('voucher_date');
				$ve->saveAndUnload();
			}

			$form->js()->univ()->successMessage("Voucher Edited SuccessFully")->closeDialog()->closeDialog()->execute();
		}

	}
}