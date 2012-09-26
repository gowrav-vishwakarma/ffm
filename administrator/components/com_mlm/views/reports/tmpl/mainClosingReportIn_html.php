<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
global $com_params;
?>
<table class="adminlist">
    <thead>
    <tr>
        <th>S No</th>
        <th>ID</th>
        <th>Name</th>
        <th>Mobile No</th>
        <th>Previous Carried</th>
        <?php if($com_params->get("PlanHasIntroductionIncome")):?>
        <th>Introduction Amount</th>
        <?php endif;?>
        <?php if($com_params->get("PlanHasLevelIncome")):?>
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
        <th>Closing Upgradation Deduction</th>
        <?php endif;?>
        <?php if($com_params->get("BinarySystem")):?>
        <th>Binary Income</th>
        <?php endif;?>
        <?php if($com_params->get("PlanHasSurveyIncome")):?>
        <th>Survey Income</th>
        <?php endif;?>
        <th>Total Amount</th>
        <th>TDS</th>
        <th>Service Charge</th>
        <th>Other Deduction</th>
        <th>Remark</th>
        <th>Net Amount</th>
        <th>Carried Forwd</th>
        <th>Bank</th>
        <th>IFSC</th>
        <th>AccountNumber</th>
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
        <?php if($com_params->get("PlanHasIntroductionIncome")):?>
        <td><?= $d->IntroductionAmount;?></td>
        <?php endif;?>
        <?php if($com_params->get("PlanHasLevelIncome")):?>
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
        <td><?= $d->ClosingUpgradationDeduction; ?></td>
        <?php endif;?>
        <?php if($com_params->get("BinarySystem")):?>
        <td><?= $d->BinaryIncome;?></td>
        <?php endif;?>
        <?php if($com_params->get("PlanHasSurveyIncome")):?>
        <td><?= $d->SurveyIncome;?></td>
        <?php endif;?>
        <td><?= $d->ClosingAmount;?></td>
        <td><?= $d->ClosingTDSAmount;?></td>
        <td><?= $d->ClosingServiceCharge;?></td>
        <td><?= $d->OtherDeductions;?></td>
        <td><?= $d->OtherDeductionRemarks;?></td>
        <td><?= $d->ClosingAmountNet;?></td>
        <td><?= $d->ClosingCarriedAmount;?></td>
        <td><?= $d->distributor->details->Bank;?></td>
        <td><?= $d->distributor->details->IFSC;?></td>
        <td><?= $d->distributor->details->AccountNumber;?></td>
    </tr>
    <?php
    $i++;
    ?>
    <?php    endforeach; ?>
    </tbody>
</table>