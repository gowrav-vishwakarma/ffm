<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_VoucherAll extends Model_Table {

    var $table = 'jos_xxvouchers';
    
    var $voucher_type;
    var $default_narration;
    var $debitledgers;
    var $creditledgers;
    var $form;
    
    function init() {
        parent::init();
        $this->hasOne('MyLedgers','ledger_id');
        $this->hasOne('Pos','pos_id')->system(true);
        $this->hasMany('VoucherDetails','voucher_id');
        $this->addField('AmountCR');
        $this->addField('AmountDR');
        $this->addField('VoucherNo')->system(true);
        $this->addField('Narration')->type('text');
        $this->addField('VoucherType')->enum('SALES','PURCHASE','JV','CONTRA')->mandatory("Voucher Type is must");
        $this->addField('RefAccount');
        // $this->addField('Rate');
        // $this->addField('Qty');
        $this->addField('has_details')->type('boolean')->system(true);
        
        $this->addCondition('pos_id',$this->api->auth->model['pos_id']);

        $this->voucher_type= null;
        $this->default_narration= null;
        $this->debitledgers=null;
        $this->creditledgers=null;
        $this->form=null;
        
    }
    
    
    function addVoucher($dr_accounts, $cr_accounts, $auto_voucher,$details=false,$refAccount=null,$narration=""){
        // pos_id set in init so always fro self pos entry
        $drsum=0;
        $crsum=0;
        foreach($dr_accounts as $key=>$val){
            if($val['Amount']=="" or $val['Amount']== null or $val['Amount']==0) continue;
            $drsum += $val['Amount'];
        }
        
        foreach($cr_accounts as $key=>$val){
            if($val['Amount']=="" or $val['Amount']== null or $val['Amount']==0) continue;
            $crsum += $val['Amount'];
        }
        

        if($crsum != $drsum OR $crsum == 0) throw $this->exception ("Debit Amount is not equal to Credit Amount or its Zero");
        
        // throw $this->exception(" $crsum :: $drsum ");

        if($auto_voucher === true){
            $cur_pos=$this->add('Model_Pos');
            $cur_pos->getCurrent();
            $auto_voucher = $cur_pos->getNextVoucherNumber($this->voucher_type);
        }
        
        if($narration=="") $narration = $this->default_narration;
        
        $details_fk=null;
        $has_details=(is_array($details)? true: false);
        
        $ve=$this->add('Model_VoucherEntry');
        
        // throw $this->exception(print_r($dr_accounts));

        foreach($dr_accounts as $key=>$val){
            if($val['Amount']=="" or $val['Amount']== null or $val['Amount']==0) continue;
            
            $ve['ledger_id']=$key;
            $ve['AmountDR']=$val['Amount'];
            $ve['VoucherNo']=$auto_voucher;
            $ve['Narration']=$narration;
            $ve['VoucherType']=$this->voucher_type;
            $ve['RefAccount']=(isset($val['RefAccount'])? $val['RefAccount']: $refAccount);
            // $ve['Rate']=(isset($val['Rate'])? $val['Rate']: "");
            // $ve['Qty']=(isset($val['Qty'])? $val['Qty']: "");
            $ve['has_details']=$has_details;
            $ve->save();
            if($details_fk === null) $details_fk=$ve->id;
            $ve->unload();
        }
        foreach($cr_accounts as $key=>$val){
            if($val['Amount']=="" or $val['Amount']== null or $val['Amount']==0) continue;
            $ve['ledger_id']=$key;
            $ve['AmountCR']=$val['Amount'];
            $ve['VoucherNo']=$auto_voucher;
            $ve['Narration']=$narration;
            $ve['VoucherType']=$this->voucher_type;
            $ve['RefAccount']=(isset($val['RefAccount'])? $val['RefAccount']: $refAccount);
            // $ve['Rate']=(isset($val['Rate'])? $val['Rate']: "");
            // $ve['Qty']=(isset($val['Qty'])? $val['Qty']: "");
            $ve['has_details']=$has_details;
            $ve->saveAndUnload();
        }
        if($has_details){
            $vd=$this->add('Model_VoucherDetails');
            foreach($details as $detail){
                $vd['voucher_id']=$details_fk;
                $vd['item_id']=$detail['item_id'];
                $vd['Rate']=$detail['Rate'];
                $vd['Qty']=$detail['Qty'];
                $vd['Amount']=$detail['Amount'];
                $vd->saveAndUnload();
            }
        }
        
    }
    
    function getForm(){
        $this->form=$this->add('Form');
    }

}