<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class page_resetall extends Page {

    function page_index(){
        $v=$this->add('View');
        $reset=$this->add('Button')->set('(1) Reset');
        $reset->js('click',$v->js(null,$reset->js(null,$v->js()->text('Resetting...'))->hide())->atk4_load($this->api->url('./reset')));

        $reset=$this->add('Button')->set('(2) Create Distributor Ledgers');
        $reset->js('click',$v->js(null,$reset->js(null,$v->js()->text('Creating...'))->hide())->atk4_load($this->api->url('./createDistributorLedgers')));

        $reset=$this->add('Button')->set('(3) Create Distributor Sales Vouchers');
        $reset->js('click',$v->js(null,$reset->js(null,$v->js()->text('Creating...'))->hide())->atk4_load($this->api->url('./createOldSaleVouchers')));
        
        $reset=$this->add('Button')->set('(4) Create Distributor Payments Vouchers');
        $reset->js('click',$v->js(null,$reset->js(null,$v->js()->text('Creating...'))->hide())->atk4_load($this->api->url('./createPaymentVouchers')));
    }

    function page_reset() {
        // parent::init();
        // $this->query("
        //         SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
        //         SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
        //         SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';");
        
        $this->query("
                truncate jos_xxkitledgers;
                truncate jos_xxstaff;
                truncate jos_xxpos;
                truncate jos_xxvouchers;
                truncate jos_xxcategory;
                truncate jos_xxgroups;
                truncate jos_xxheads;
                truncate jos_xxitems;
                truncate jos_xxledgers;
                truncate jos_xxparties;
                truncate jos_xxstocks;
                truncate jos_xxkittransfers;
                ");
        
//        @TODO@ -- Default heads and groups and ledgers

        $p=$this->add('Model_Pos');
        $p['owner_id']=1;
        $p['name']="COMPANY POS";
        $p['type']='Company';
        $p->memorize('reset_mode',true);
        $p->save();
        
        $s=$p->ref('Staff')->loadAny();
        $s['AccessLevel']=1000;
        $s->save();

        // ADD 2 no staff as Admin with pos_id=0

        $s=$this->add('Model_Staff');
        $s['pos_id']=0;
        $s['username']='ffmadmin';
        $s['password']='ffmadmin';
        $s['AccessLevel']=1000;
        $s['name']="ffmadmin";
        $s->save();

        
//        Add all heads and default groups
        $q="
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (1, 'Capital Account', 'Liability', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (2, 'Loans (Liability)', 'Liability', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (3, 'Current Liabilities', 'Liability', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (4, 'Suspance Account', 'Liability', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (5, 'Branch And Division', 'Liability', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (6, 'Fixed Assets', 'Asset', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (7, 'Investements', 'Asset', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (8, 'Current Assets', 'Asset', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (9, 'Loans And Advances (Assets)', 'Asset', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (10, 'Direct Expenses', 'P&L', 1);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (11, 'InDirect Expenses', 'P&L', 1);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (12, 'Direct Income', 'P&L', 1);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (13, 'InDirect Income', 'P&L', 1);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (14, 'Purchase Account', 'P&L', 1);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (15, 'Sales Account', 'P&L', 1);

            ";
        $this->query($q);
//        @TODO@ -- root group for tree management in jos_xxgroups to add
        $this->query("INSERT INTO `ffm`.`jos_xxgroups` (`name`, `lft`,`rgt`) VALUES ('root', 0,1);");

        $groups_arr=array(
                "Capital Account"       =>1,/*2*/
                "Bank OD"               =>2,/*3*/
                "Bank CC"               =>2,
                "Bank Loan"             =>1,
                "Secured Loan"          =>1,
                "Un Secured Loan"       =>2,
                "Sundry Creditors"      =>3,
                "Duties And Taxes"      =>3,
                "Provisions"            =>3,/*10*/
                "Suspance"              =>4,
                "Branches And Divisions"=>5,
                "Fixed Assets"          =>6,
                "Investments"           =>7,
                "Closing Stocks"        =>8,/*15*/
                "Current Assets"        =>8,
                "Loan And Advances (Assets)" =>8,
                "Sundry Debtors"        =>8,
                "Bank Accounts"         =>8,
                "Direct Expenses"       =>10,/*20*/
                "In Direct Expenses"    =>11,
                "Direct Income"         =>12,
                "In Direct Income"      =>13,
                "Purchase Account"      =>14,
                "Sales Account"         =>15,/*25*/
                "Distributors"          =>3
                );

        foreach($groups_arr as $grp=>$head){
            $ng=$this->add('Model_GroupsAll');
            $ng['name']     =   $grp;
            $ng['head_id']  =   $head;
            $ng->saveAndUnload();
        }

        // Create a few SUB Groups
        $sub_groups_arr=array(
                "Cash Group" => array("ParentGroupID"=>16,"ParentGroupHeadID"=>8) /*27*/
            );
        
        foreach($sub_groups_arr as $grp=>$grd_details){
            $ng=$this->add('Model_GroupsAll');
            $ng['name']     =   $grp;
            $ng['head_id']  =   $grd_details["ParentGroupHeadID"];
            $ng['group_id']  =   $grd_details["ParentGroupID"];
            $ng->saveAndUnload();
        }        

        // @TODO@ -- Create Default Ledgers
        $ledger_array=array(
            "Cash" => 27 /*Group/SubGroup ID*/,//Ledger ID 2
            DISCOUNT_GIVEN =>21,
            DISCOUNT_TAKEN =>23, 
            "Purchase Account"=>24,
            "Sales Account"=>25, //Ledger ID 6
            "TDS" => 9, /* Under Duties and Taxes : Ledger ID 7 */
            "Commission" => 20 /*Under Direct Expense : Ledger ID 8 */
        );

        // @TODO@ -- Create kitledgers in default mode

        foreach($ledger_array as $ladger=>$group_head){
            $lam=$this->add("Model_LedgerAll");
            $lam['name']= $ladger;
            $lam['group_id']=$group_head;
            $lam['default_account']=true;
            $lam->saveAndUnload();
        }

        // PIN TABLE ADD POS_ID
        // $this->query("ALTER TABLE `ffm`.`jos_xpinmaster` ADD COLUMN `pos_id` INT NULL  AFTER `updated_at`;");
        // $this->query("ALTER TABLE `ffm`.`jos_xpinmaster` ADD COLUMN `under_pos` TINYINT(1) NULL  AFTER `pos_id` ;");
        $this->query("DELETE FROM ffm.jos_xpinmaster WHERE Used=0;");

        // Create Kit Ledgers

        $kitledgers=array(
            /*Kit ID*/1=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/2=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/11=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/12=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/13=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/14=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/15=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/16=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/17=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/18=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/19=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/20=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/21=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/22=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/23=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/24=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/25=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/26=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/27=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/28=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/29=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/30=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/32=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/33=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            /*Kit ID*/34=>array(
                    /*Ledger ID*/6=>/*Amount*/ 500
                ),
            );

        $k=$this->add('Model_KitLedgers');
        foreach($kitledgers as $kitid=>$ledgers){
            foreach($ledgers as $ledgerid=>$amount){
                $k['kit_id']=$kitid;
                $k['ledger_id']=$ledgerid;
                $k['Amount']=$amount;
                $k->saveAndUnload();
            }
        }

        $this->page_oldPins();
        $this->add('Text')->set('Reset Done');
    }

    function page_createDistributorLedgers(){
        $this->query("INSERT into jos_xxledgers 
                (SELECT 
                    0,
                    concat(t.id,' ',p.Name),
                    now(),
                    now(),
                    t.id,
                    26 /*Distributors Group*/,
                    null,
                    null,
                    1,
                    null,
                    null
                FROM
                    jos_xtreedetails t join jos_xpersonaldetails p on p.distributor_id=t.id
            )
            ");
        $this->add('Text')->set('Ledgers Created');
    }


    function page_createPaymentVouchers(){
        $clossings=$this->add('Model_Closing');
        $clossings->addCondition('ClosingAmountNet','>',0);
        $comm=$this->add('Model_CommissionVoucher');
        foreach($clossings as $c){
            $on_date=date("Y-m-d",strtotime(str_replace("_", "-", $c['closing'])));
            $dr_accounts=array(
                    7 => array("Amount"=>$c['ClosingTDSAmount']),
                    8 => array("Amount"=>$c['ClosingAmountNet'])
                );

            $l_from=$this->add('Model_LedgerAll');
            $l_from->getDistributorLedger($c['distributor_id']);
            
            $cr_accounts=array(
                    $l_from->id => array("Amount"=>$c['ClosingTDSAmount'] + $c['ClosingAmountNet'])
                );


            $comm->addVoucher($dr_accounts, $cr_accounts, true,false,$c['distributor_id'],null,$on_date);
            $l_from->destroy();
        }
        $this->add('Text')->set('Payment Vouchers Creation Done');
    }


    function page_createOldSaleVouchers(){
        $dist=$this->add('Model_Distributor');
        foreach($dist as $junk){
            $k=$this->add('Model_Kit')->load($dist['kit_id']);
            $p=$this->add('Model_Pin')->load($dist['pin_id']);
            
            $l_from=$this->add('Model_LedgerAll');
            $l_to=$this->add('Model_LedgerAll');

            $l_from->getDistributorLedger($p['adcrd_id']);
            $l_to->getDistributorLedger($dist->id);

            $k->doSales(1,$l_to->id,$l_from->id,"Joining of ". $dist->id, $dist['JoiningDate']);
            $k->destroy();
            $l_from->destroy();
            $l_to->destroy();
            unset($k);
        }

        $this->query("UPDATE jos_xxvouchers SET pos_id=1");
        $this->add('Text')->set('Commission Vouchers Creation Done');
    }

    function page_oldPins(){
        $this->query("UPDATE jos_xpinmaster SET pos_id=1, under_pos=0");
    }

    
    function query($q){
        $this->api->db->dsql()->expr($q)->execute();
    }

    function page_temp(){
        $this->add('Text')->set(date("Y-m-d",strtotime("1-sep-2011")));
    }

}