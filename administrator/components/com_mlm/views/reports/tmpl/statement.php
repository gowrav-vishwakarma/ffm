<?php
$conf = & JFactory::getConfig();


//$details = new Details();
//$details->where("distributor_id", $data->distributor_id)->get();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//echo $data->IntroductionAmount.'<br>';
?><head>
    <script language="javascript" type="application/javascript">
 window.print() ;
 </script>
<style>
.break { page-break-after: always; }
</style>
</head>

<table class="break" width="100%" border="1" cellpadding="3">
    <tr>
        <th colspan="5" align="center"><h1>Family Future Business</h1>
        <p>A53, Lucky Mension, Opp. Hansa Palace,
Sector - 4, Hiran Magri Main Road, Udaipur (Raj.)
</th>
    </tr>
    
    <tr>
        <td align="center" colspan="5"><strong>Statement for Closing :
                <?= inp("closing") ?>
            </strong></td>
    </tr>
    <tr>
        <td colspan="5" > <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td colspan="2" align="center"><strong>Distributor Details</strong></td>
                </tr>
                <tr>
                    <td width="50%" align="right"><strong>ID</strong></td>
                    <td width="50%"><?= $data->distributor_id ?></td>
                </tr>
                <tr>
                    <td align="right"><strong>Name</strong></td>
                    <td><?= $data->distributor->detail->Name; ?></td>
                </tr>
                <tr>
                    <td align="right"><strong>Address</strong></td>
                    <td><?= $data->distributor->detail->Address ?></td>
                </tr>
                <tr>
                    <td align="right"><strong>Joining Date</strong></td>
                    <td><?= $data->distributor->JoiningDate; ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td colspan="5" align="center"><strong>Income Details</strong></td>
    </tr>
    <tr>
        <td colspan="4" align="right">RMB</td>
        <td width="12%"><?= $data->RMB ?></td>
    </tr>
    <tr>
        <td colspan="4" align="right">Introduction Income</td>
        <td><?= $data->IntroductionAmount ?></td>
    </tr>
        <tr>
        <td colspan="4" align="center"><strong>Level Income Details</strong></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="14%"><strong>S.No</strong></td>
        <td width="34%"><strong>RMB Points Achieved</strong></td>
        <td width="19%"><strong>Level %</strong></td>
        <td width="21%"><strong>Level Income</strong></td>
        <td>&nbsp;</td>
    </tr>
    <?php
    $total = 0;
                for ($i = 1; $i <= 10; $i++) {
    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td>
            <?php
                    $li = "Level$i";
                    $li = $data->$li;
                    echo ($li/(600*$levelincome->getkey('IncomeLevel' . $i)));
            ?>
                </td>
                <td><?= $levelincome->getkey('IncomeLevel' . $i) * 100 ?></td>
                <td><?php
                    $li = "Level$i";
                    echo $data->$li;
                    $total += $data->$li?></td>
                <td>&nbsp;</td>
            </tr>
    <?php
                }
    ?>
            <tr>
                    <td colspan="4" align="right" ><strong>Level Income</strong></td>
                    <td><?= $total ?></td>
                </tr>
                <tr>
                    <td colspan="4" align="right"><strong>Previous Carried</strong></td>
                    <td><?= $data->LastClosingCarryAmount ?></td>
                </tr>
                <tr>
                    <td colspan="4" align="right"><strong>Total</strong></td>
                    <td><?= $data->ClosingAmount ?></td>
                </tr>
                <tr>
                    <td colspan="4" align="right"><strong>Admin Charge @ 5 % (-)</strong></td>
                    <td><?= $data->ClosingServiceCharge ?></td>
                </tr>
                <tr>
                    <td colspan="4" align="right"><strong>TDS @ 10 % (-)</strong></td>
                    <td><?= $data->ClosingTDSAmount ?></td>
                </tr>
                <tr>
                    <td colspan="4" align="right"><strong>Net Payable (Rounded To)</strong></td>
                    <td><?= $data->ClosingAmountNet ?></td>
                </tr>
                <tr>
                    <td colspan="4" align="right"><strong>Carry Forwarded Amount</strong></td>
                    <td><?= $data->ClosingCarriedAmount ?></td>
    </tr>
</table>



