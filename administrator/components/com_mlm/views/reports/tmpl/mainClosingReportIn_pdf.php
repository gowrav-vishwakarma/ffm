<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<table class="adminlist">
    <thead>
    <tr>
        <th>S No</th>
        <th>ID</th>
        <th>Name</th>
        <th>Mobile No</th>
        <th>Previous Carried</th>
        <th>Introduction Amount</th>
        <th>RMB</th>
        <th>Level 1</th>
        <th>Level 2</th>
        <th>Level 3</th>
        <th>Level 4</th>
        <th>Level 5</th>
        <th>Level 6</th>
        <th>Level 7</th>
        <th>Level 8</th>
        <th>Level 9</th>
        <th>Level 10</th>
        <th>Total</th>
        <th>TDS</th>
        <th>Service Charge</th>
        <th>Other Deduction</th>
        <th>Remark</th>
        <th>Net Amount</th>
        <th>Carried Forwd</th>
        <th>Cheque No</th>
        <th>Curior No</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i=1;
    ?>
    <?php foreach($data as $d): ?>
    <tr class="row<?php echo $i % 2 ?>">
        <td><?= $i;?></td>
        <td><?= $d->distributor->id;?></td>
        <td><?= $d->distributor->detail->Name;?></td>
        <td><?= $d->distributor->detail->MobileNo;?></td>
        <td><?= $d->LastClosingCarryAmount;?></td>
        <td><?= $d->IntroductionAmount;?></td>
        <td><?= $d->RMB;?></td>
        <td><?= $d->Level1;?></td>
        <td><?= $d->Level2;?></td>
        <td><?= $d->Level3;?></td>
        <td><?= $d->Level4;?></td>
        <td><?= $d->Level5;?></td>
        <td><?= $d->Level6;?></td>
        <td><?= $d->Level7;?></td>
        <td><?= $d->Level8;?></td>
        <td><?= $d->Level9;?></td>
        <td><?= $d->Level10;?></td>
        <td><?= $d->ClosingAmount;?></td>
        <td><?= $d->ClosingTDSAmount;?></td>
        <td><?= $d->ClosingServiceCharge;?></td>
        <td><?= $d->OtherDeductions;?></td>
        <td><?= $d->OtherDeductionRemarks;?></td>
        <td><?= $d->ClosingAmountNet;?></td>
        <td><?= $d->ClosingCarriedAmount;?></td>
        <td><?= $d->ChequeNo;?></td>
        <td><?= $d->CuriorNo;?></td>
    </tr>
    <?php
    $i++;
    ?>
    <?php    endforeach; ?>
    </tbody>
</table>