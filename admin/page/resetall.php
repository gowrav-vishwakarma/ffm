<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class page_resetall extends Page {

    function page_index() {
        $v = $this->add('View');
        $reset = $this->add('Button')->set('(1) Reset');
        $reset->js('click', $v->js(null, $reset->js(null, $v->js()->text('Resetting...'))->hide())->atk4_load($this->api->url('./reset')));

        $reset = $this->add('Button')->set("(2) Create Distributor Ledgers");
        $reset->js('click', $v->js(null, $reset->js(null, $v->js()->text('Creating...'))->hide())->atk4_load($this->api->url('./createDistributorLedgers')));

        $distscount = $this->add('Model_Distributor')->count()->getOne();
        $pages = $distscount / 100;
        if ($distscount % 100 > 0)
            $pages++;
        for ($i = 0; $i < $pages; $i++) {
            $reset = $this->add('Button')->set("(3 . $i) Create Distributor Sales Vouchers")->setStyle('border', '2px solid green');
            $reset->js('click', $v->js(null, $reset->js(null, $v->js()->text('Creating...'))->hide())->atk4_load($this->api->url('./createOldSaleVouchers')->setArguments(array('dist_page' => $i))));
        }

        for ($i = 0; $i < $pages; $i++) {
            $reset = $this->add('Button')->set("(4 . $i) Create Distributor Payment Receipt Vouchers")->setStyle('border', '2px solid orange');
            $reset->js('click', $v->js(null, $reset->js(null, $v->js()->text('Creating...'))->hide())->atk4_load($this->api->url('./createJoiningPaymentVouchers')->setArguments(array('dist_page' => $i))));
        }

        $clossings = $this->add('Model_Closing');
        $clossings->addCondition('ClosingAmountNet', '>', 0);
        $closing_pages = ($clossings->count()->getOne() / 100);
        if ($closing_pages % 100 > 0)
            $closing_pages++;
        for ($i = 0; $i < $closing_pages; $i++) {
            $reset = $this->add('Button')->set("(5. $i) Create Distributor Commission Vouchers")->setStyle('border', '2px solid red');
            $reset->js('click', $v->js(
                            null, $reset->js(
                                    null, $v->js()->text('Creating...')
                            )->hide()
                    )->atk4_load($this->api->url('./createCommissionVouchers')->setArguments(array('closing_page' => $i))));
        }


        for ($i = 0; $i < $closing_pages; $i++) {
            $reset = $this->add('Button')->set("(5. $i) Create Distributor Payout Vouchers")->setStyle('border', '2px solid blue');
            $reset->js('click', $v->js(
                            null, $reset->js(
                                    null, $v->js()->text('Creating...')
                            )->hide()
                    )->atk4_load($this->api->url('./createPayoutVouchers')->setArguments(array('closing_page' => $i))));
        }

        $reset = $this->add('Button')->set('(5) kit Send Marked');
        $reset->js('click', $v->js(null, $reset->js(null, $v->js()->text('Sending Kits...'))->hide())->atk4_load($this->api->url('./sendKitsMarked')));
        
        $reset = $this->add('Button')->set('Closing Name to Date');
        $reset->js('click', $v->js(null, $reset->js(null, $v->js()->text('Correcting closing name...'))->hide())->atk4_load($this->api->url('./correctClosingNames')));
    }

    function page_reset() {
        // parent::init();
        // $this->query("
        //         SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
        //         SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
        //         SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';");

        $this->query("
                truncate jos_xxledgers;
                truncate jos_xxkitledgers;
                truncate jos_xxstaff;
                truncate jos_xxstocks;
                truncate jos_xxpos;
                truncate jos_xxvouchers;
                truncate jos_xxvoucherdetails;
                truncate jos_xxcategory;
                truncate jos_xxgroups;
                truncate jos_xxheads;
                truncate jos_xxitems;
                truncate jos_xxparties;
                truncate jos_xxkittransfers;
                ");

//        @TODO@ -- Default heads and groups and ledgers

        $p = $this->add('Model_Pos');
        $p['owner_id'] = 1;
        $p['name'] = "COMPANY POS";
        $p['type'] = 'Company';
        $p->memorize('reset_mode', true);
        $p->save();

        $s = $p->ref('Staff')->loadAny();
        $s['AccessLevel'] = 1000;
        $s->save();

        // ADD 2 no staff as Admin with pos_id=0

        $s = $this->add('Model_Staff');
        $s['pos_id'] = 0;
        $s['username'] = 'ffmadmin';
        $s['password'] = 'ffmadmin';
        $s['AccessLevel'] = 1000;
        $s['name'] = "ffmadmin";
        $s->save();

        $this->query("UPDATE jos_xxstaff SET pos_id=0 WHERE pos_id is null");


//        Add all heads and default groups
        $head_array = array(
            array(1, 'Capital Account', 'Liability', 0),
            array(2, 'Loans (Liability)', 'Liability', 0),
            array(3, 'Current Liabilities', 'Liability', 0),
            array(4, 'Suspance Account', 'Liability', 0),
            array(5, 'Branch And Division', 'Liability', 0),
            array(6, 'Fixed Assets', 'Asset', 0),
            array(7, 'Investements', 'Asset', 0),
            array(8, 'Current Assets', 'Asset', 0),
            array(9, 'Loans And Advances (Assets)', 'Asset', 0),
            array(10, 'Direct Expenses', 'P&L', 1),
            array(11, 'InDirect Expenses', 'P&L', 1),
            array(12, 'Direct Income', 'P&L', 1),
            array(13, 'InDirect Income', 'P&L', 1),
            array(14, 'Purchase Account', 'P&L', 1),
            array(15, 'Sales Account', 'P&L', 1)
        );

        foreach ($head_array as $hd) {
            $t = $this->add('Model_Head');
            $t['name'] = $hd[1];
            $t['type'] = $hd[2];
            $t['isPANDL'] = $hd[3];
            $t->saveAndUnload();
        }
//        @TODO@ -- root group for tree management in jos_xxgroups to add
        $this->query("INSERT INTO `jos_xxgroups` (`name`, `lft`,`rgt`) VALUES ('root', 0,1);");

        $groups_arr = array(
            /* 2 */"Capital Account" => 1, /* 2 */
            "Bank OD" => 2, /* 3 */
            "Bank CC" => 2,
            /* 5 */"Bank Loan" => 1,
            "Secured Loan" => 1,
            "Un Secured Loan" => 2,
            "Sundry Creditors" => 3,
            "Duties And Taxes" => 3,
            /* 10 */"Provisions" => 3, /* 10 */
            "Suspance" => 4,
            "Branches And Divisions" => 5,
            "Fixed Assets" => 6,
            "Investments" => 7,
            /* 15 */"Closing Stocks" => 8, /* 15 */
            "Current Assets" => 8,
            "Loan And Advances (Assets)" => 8,
            "Sundry Debtors" => 8,
            "Bank Accounts" => 8,
            /* 20 */"Direct Expenses" => 10, /* 20 */
            "In Direct Expenses" => 11,
            "Direct Income" => 12,
            "In Direct Income" => 13,
            "Purchase Account" => 14,
            /* 25 */"Sales Account" => 15, /* 25 */
            "Distributors" => 3,
            "Loans (Liability)" => 2,
        );

        foreach ($groups_arr as $grp => $head) {
            $ng = $this->add('Model_GroupsAll');
            $ng['name'] = $grp;
            $ng['head_id'] = $head;
            $ng->saveAndUnload();
        }

        // Create a few SUB Groups
        $sub_groups_arr = array(
            "Cash Group" => array("ParentGroupID" => 16, "ParentGroupHeadID" => 8) /* 27 */
        );

        foreach ($sub_groups_arr as $grp => $grd_details) {
            $ng = $this->add('Model_GroupsAll');
            $ng['name'] = $grp;
            $ng['head_id'] = $grd_details["ParentGroupHeadID"];
            $ng['group_id'] = $grd_details["ParentGroupID"];
            $ng->saveAndUnload();
        }

        // @TODO@ -- Create Default Ledgers
        $ledger_array = array(
            /* 2 */"Cash" => 27 /* Group/SubGroup ID */,
            /* 3 */DISCOUNT_GIVEN => 21,
            /* 4 */DISCOUNT_TAKEN => 23,
            /* 5 */"Purchase Account" => 24,
            /* 6 */"Sales Account" => 25,
            /* 7 */"TDS" => 9, /* Under Duties and Taxes */
            /* 8 */"Commission" => 20, /* Under Direct Expense */
            /* 9 */"Service Tax Payable" => 9, /* Under Duties and Taxes */
            /* 10 */"Holiday Voucher Sales" => 25, /* Sales Account */
            /* 11 */"P and C Paint Shirt Sales" => 25, /* Sales Account */
            /* 12 */"My Choice Paint Shirt Sales" => 25, /* Sales Account */
            /* 13 */"BSL Paint Shirt Sales" => 25, /* Sales Account */
            /* 14 */"Combo Paint Shirt Sales" => 25, /* Sales Account */
            /* 15 */"Economy Paint Shirt Sales" => 25, /* Sales Account */
            /* 16 */"Diamond Paint Shirt Sales" => 25, /* Sales Account */
            /* 17 */"Electro Paint Shirt Sales" => 25, /* Sales Account */
            /* 18 */"Executive Suit Length Sales" => 25, /* Sales Account */
            /* 19 */"International Paint Shirt Sales" => 25, /* Sales Account */
            /* 20 */"Best Paint Shirt Sales" => 25, /* Sales Account */
            /* 21 */"Executive Paint Shirt Sales" => 25, /* Sales Account */
            /* 22 */"XYZ Bank Account" => 19, /* Bank Account */
            /* 23 */"Service Charge" => 23, /* In Direct Income */
            /* 24 */"Other Deductions" => 23, /* In Direct Income */
            /* 25 */"First Payout Deduction" => 27, /* Loans (Liability) */
            /* 26 */"Upgradation Deduction" => 27 /* Loans (Liability) */
        );

        // @TODO@ -- Create kitledgers in default mode

        foreach ($ledger_array as $ladger => $group_head) {
            $lam = $this->add("Model_LedgerAll");
            $lam['name'] = $ladger;
            $lam['group_id'] = $group_head;
            $lam['default_account'] = true;
            $lam->saveAndUnload();
        }

        // PIN TABLE ADD POS_ID
        // $this->query("ALTER TABLE `jos_xpinmaster` ADD COLUMN `pos_id` INT NULL  AFTER `updated_at`;");
        // $this->query("ALTER TABLE `jos_xpinmaster` ADD COLUMN `under_pos` TINYINT(1) NULL  AFTER `pos_id` ;");
        // $this->query("DELETE FROM jos_xpinmaster WHERE Used=0;");
        // Create Kit Ledgers

        $kitledgers = array(
            /* Kit ID Easy kit */1 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                11 => 400
            ),
            /* Kit ID FFM Pack yfoc 2=>array(
              10 =>691.45,
              9 => 8.55,
              11=> 400
              ), */
            /* Kit ID Kit no 3 */11 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                13 => 1100
            ),
            /* Kit ID kit no 4 */12 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                12 => 1300
            ),
            /* Kit ID Kit NO 2 */13 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                14 => 900
            ),
            /* Kit ID Kit No 6 */14 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                14 => 234
            ),
            /* Kit ID Kit nO 7 */15 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                18 => 5300
            ),
            /* Kit ID Kit No 8 */16 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                19 => 6300
            ),
            /* Kit ID Kit No 9 */17 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                11 => 10800
            ),
            /* Kit ID kit no 5 */18 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                16 => 2800
            ),
            /* Kit ID Kit No 10 */19 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                11 => 14300
            ),
            /* Kit ID Kit No 1 ============= */20 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                11 => 800
            ),
            /* Kit ID Economy Pack */21 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                12 => 1300
            ),
            /* Kit ID Safety Pack */22 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                15 => 2300
            ),
            /* Kit ID Diamond Pack */23 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                16 => 2800
            ),
            /* Kit ID Electro Pack */24 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                17 => 3800
            ),
            /* Kit ID Combo Pack */25 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                18 => 5300
            ),
            /* Kit ID Secure Pack 1 */26 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                19 => 6300
            ),
            /* Kit ID Secure Pack 2 */27 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                11 => 9300
            ),
            /* Kit ID Secure Pack 3 */28 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                11 => 11300
            ),
            /* Kit ID Secure Pack 4 */29 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                11 => 14300
            ),
            /* Kit ID International Pack */30 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                11 => 24300
            ),
            /* Kit ID Family Pack 1 */31 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                21 => 900
            ),
            /* Kit ID Family Pack 2 */32 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                20 => 1300
            ),
            /* Kit ID Family Pack 3 */33 => array(
                /* Ledger ID */10 => /* Amount */ 691.45,
                9 => 8.55,
                14 => 3300
            ),
        );

        $k = $this->add('Model_KitLedgers');
        foreach ($kitledgers as $kitid => $ledgers) {
            foreach ($ledgers as $ledgerid => $amount) {
                $k['kit_id'] = $kitid;
                $k['ledger_id'] = $ledgerid;
                $k['Amount'] = $amount;
                $k->saveAndUnload();
            }
        }

        $this->page_oldPins();
        $this->add('Text')->set('Reset Done');
    }

    function page_createDistributorLedgers() {
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

    function page_createOldSaleVouchers() {
        $dist = $this->add('Model_Distributor');
        $dist->_dsql()->limit(100, $_GET['dist_page'] * 100);
        $vn = $_GET['dist_page'] * 100 + 1;
        foreach ($dist as $junk) {
            $k = $this->add('Model_Kit')->load($dist['kit_id']);
            $p = $this->add('Model_Pin')->load($dist['pin_id']);

            $l_from = $this->add('Model_LedgerAll');
            $l_to = $this->add('Model_LedgerAll');

            $l_from->getDistributorLedger($p['adcrd_id']);
            $l_to->getDistributorLedger($dist->id);

            $k->doSales(1, $l_to->id, $l_from->id, "Joining of " . $dist->id, $dist['JoiningDate'], $vn++);
            $k->destroy();
            $l_from->destroy();
            $l_to->destroy();
            unset($k);
        }

        $this->query("UPDATE jos_xxvouchers SET pos_id=1");
        $this->add('Text')->set('Commission Vouchers Creation Done for page' . $_GET['dist_page']);
    }

    function page_createJoiningPaymentVouchers() {
        $dist = $this->add('Model_Distributor');
        $dist->_dsql()->limit(100, $_GET['dist_page'] * 100);
        $vn = $_GET['dist_page'] * 100 + 1;
        $mv = $this->add('Model_PaymentReceivedVoucher');
        foreach ($dist as $junk) {

            $mrp = $dist->ref('kit_id')->get('MRP');

            $l_from = $this->add('Model_LedgerAll');
            $l_from->getDistributorLedger($dist->id);

            $dr_accounts = array(
                22 => array("Amount" => $mrp)
            );

            $cr_accounts = array(
                $l_from->id => array("Amount" => $mrp)
            );
            if ($mrp != 0)
                $mv->addVoucher($dr_accounts, $cr_accounts, $vn++, false, $dist->id, null, $dist['JoiningDate']);
        }
        $this->query("UPDATE jos_xxvouchers SET pos_id=1");
        $this->add('Text')->set('Joining Payement Receipt Vouchers Creation Done for page' . $_GET['dist_page']);
    }

    function page_createCommissionVouchers() {
        $clossings = $this->add('Model_Closing');
        $clossings->addCondition('ClosingAmountNet', '>', 0);
        $clossings->_dsql()->limit(100, $_GET['closing_page'] * 100);
        // throw $this->exception($_GET['closing_page']);
        $comm = $this->add('Model_CommissionVoucher');
        $vn = $_GET['closing_page'] * 100 + 1;
        foreach ($clossings as $c) {
            $on_date = date("Y-m-d", strtotime(str_replace("_", "-", $c['closing'])));
            $dr_accounts = array(
                7 => array("Amount" => $c['ClosingTDSAmount']),
                8 => array("Amount" => $c['ClosingAmountNet']),
                23 => array("Amount" => $c['ClosingServiceCharge']),
                24 => array('Amount' => $c['OtherDeductions']),
                25 => array('Amount' => $c['FirstPayoutDeduction']),
                26 => array('Amount' => $c['ClosingUpgradationDeduction'])
            );

            $l_from = $this->add('Model_LedgerAll');
            $l_from->getDistributorLedger($c['distributor_id']);

            $cr_accounts = array(
                $l_from->id => array("Amount" => $c['ClosingAmount'])
            );


            $comm->addVoucher($dr_accounts, $cr_accounts, $vn++, false, $c['distributor_id'], null, $on_date);
            $l_from->destroy();
        }
        $this->query("UPDATE jos_xxvouchers SET pos_id=1");
        $this->add('Text')->set('Comission Vouchers Creation Done for page ' . $_GET['closing_page']);
    }

    function page_createPayoutVouchers() {
        $clossings = $this->add('Model_Closing');
        $clossings->addCondition('ClosingAmountNet', '>', 0);
        $clossings->_dsql()->limit(100, $_GET['closing_page'] * 100);
        // throw $this->exception($_GET['closing_page']);
        $comm = $this->add('Model_PaymentVoucher');
        $vn = $_GET['closing_page'] * 100 + 1;
        foreach ($clossings as $c) {
            $on_date = date("Y-m-d", strtotime(str_replace("_", "-", $c['closing'])));
            $cr_accounts = array(
                22 => array("Amount" => $c['ClosingAmountNet'])
            );

            $l_from = $this->add('Model_LedgerAll');
            $l_from->getDistributorLedger($c['distributor_id']);

            $dr_accounts = array(
                $l_from->id => array("Amount" => $c['ClosingAmountNet'])
            );


            $comm->addVoucher($dr_accounts, $cr_accounts, $vn++, false, $c['distributor_id'], null, $on_date);
            $l_from->destroy();
        }
        $this->query("UPDATE jos_xxvouchers SET pos_id=1");
        $this->add('Text')->set('Payment Vouchers Creation Done for page ' . $_GET['closing_page']);
    }

    function page_correctClosingNames() {
//        $on_date=date("Y-m-d",strtotime(str_replace("_", "-", $c['closing'])));
        $c = $this->add('Model_Closing');
        $c=$c->dsql();
        $c->del('field')->field($c->expr('DISTINCT(closing) as name'));
        foreach ($c as $junk) {
            $on_date = date("Y-m-d", strtotime(str_replace("_", "-", $junk['name'])));
//            $this->add('Text')->set($on_date);
            $this->query("UPDATE jos_xclosingmain SET closing='$on_date' WHERE closing = '" . $junk['name'] . "' ");
        }
        
        $this->query('ALTER TABLE `jos_xclosingmain` CHANGE `closing` `closing` DATETIME NOT NULL ');
    }

    function page_oldPins() {
        $this->query("UPDATE jos_xpinmaster SET pos_id=1, under_pos=0");
    }

    function query($q) {
        $this->api->db->dsql()->expr($q)->execute();
    }

    function page_temp() {
        $this->add('Text')->set(date("Y-m-d", strtotime("1-sep-2011")));
    }

}