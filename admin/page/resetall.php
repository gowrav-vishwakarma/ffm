<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class page_resetall extends Page {

    function init() {
        parent::init();
        $this->query("
                SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
                SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
                SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';");
        
        $this->query("
                truncate jos_xxcategory;
                truncate jos_xxgroups;
                truncate jos_xxheads;
                truncate jos_xxitems;
                truncate jos_xxledgers;
                truncate jos_xxparties;
                truncate jos_xxstaff;
                truncate jos_xxstocks;
                truncate jos_xxvouchers;
                truncate jos_xxpos;");
        $this->add('HelloWorld');
        
//        @TODO@ -- Default heads and groups and ledgers

        $p=$this->add('Model_Pos');
        $p['owner_id']=1;
        $p['name']="COMPANY POS";
        $p['type']='Company';
        $p->save();
        
        $s=$p->ref('Staff')->loadAny();
        $s['AccessLevel']=1000;
        $s->save();
        
//        Add all heads and default groups
        $q="
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (0, 'Capital Account', 'Liability', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (0, 'Loans (Liability)', 'Liability', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (0, 'Current Liabilities', 'Liability', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (0, 'Suspance Account', 'Liability', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (0, 'Branch And Division', 'Liability', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (0, 'Fixed Assets', 'Asset', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (0, 'Investements', 'Asset', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (0, 'Current Assets', 'Asset', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (0, 'Loans And Advances (Assets)', 'Asset', 0);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (0, 'Direct Expenses', 'P&L', 1);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (0, 'InDirect Expenses', 'P&L', 1);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (0, 'Direct Income', 'P&L', 1);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (0, 'InDirect Income', 'P&L', 1);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (0, 'Purchase Account', 'P&L', 1);
            INSERT INTO `ffm`.`jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES (0, 'Sales Account', 'P&L', 1);

            ";
        $this->query($q);
//        @TODO@ -- root group for tree management in jos_xxgroups to add
        $this->query("INSERT INTO `ffm`.`jos_xxgroups` (`name`, `lft`,`rgt`) VALUES ('root', 0,1);");

        $groups_arr=array(
                "Capital Account"       =>1, /*2*/
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

        // @TODO@ -- Create Default Ledgers
        $ledger_array=array(
            "Cash" => 8 /*Group ID*/,
            DISCOUNT_GIVEN =>11,
            DISCOUNT_TAKEN =>13,
            "Purchase Account"=>13,
            "Sales Account"=>15
        );

        foreach($ledger_array as $ladger=>$group_head){
            $lam=$this->add("Model_LedgerAll");
            $lam['name']= $ladger;
            $lam['group_id']=$group_head;
            $lam->saveAndUnload();
        }

        // PIN TABLE ADD POS_ID
        // $this->query("ALTER TABLE `ffm`.`jos_xpinmaster` ADD COLUMN `pos_id` INT NULL  AFTER `updated_at`;");


        $this->query("
            SET SQL_MODE=@OLD_SQL_MODE;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
            SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
        ");
        
    }
    
    function query($q){
        $this->api->db->dsql()->expr($q)->execute();
    }

}