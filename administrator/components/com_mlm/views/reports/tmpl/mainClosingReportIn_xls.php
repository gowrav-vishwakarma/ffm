<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
global $com_params;
$i=1;
?>
S No,ID,Name,Mobile No,JoiingDate,Previous Carried,<?php if($com_params->get("PlanHasIntroductionIncome")):?>Introduction Amount,<?php endif;?><?php if($com_params->get("PlanHasLevelIncome")):?>RMB,Level 1,Level 2,Level 3,Level 4,Level 5,Level 6,Level 7,Level 8,Level 9,Level 10,<?php endif;?><?php if($com_params->get("BinarySystem")):?>Binary Income,Future Income,<?php endif;?><?php if($com_params->get("PlanHasSurveyIncome")):?>Survey Income,<?php endif;?>Total Amount,TDS,Service Charge,Other Deduction,Remark,First Payout Deduction,Net Amount,Carried Forwd,Bank,IFSC,Account Number,Closing Upgradation Deduction,PanNo
<?php foreach($data as $d): ?>
    <?= $i++;?>,<?= $d->distributor->id;?>,<?= $d->distributor->detail->Name;?>,<?= $d->distributor->detail->MobileNo;?>,<?= $d->distributor->JoiningDate;?>,<?= $d->LastClosingCarryAmount;?>,<?php if($com_params->get("PlanHasIntroductionIncome")):?><?= $d->IntroductionAmount;?>,<?php endif;?><?php if($com_params->get("PlanHasLevelIncome")):?><?= $d->RMB;?>,<?= $d->Level1;?>,<?= $d->Level2;?>,<?= $d->Level3;?>,<?= $d->Level4;?>,<?= $d->Level5;?>,<?= $d->Level6;?>,<?= $d->Level7;?>,<?= $d->Level8;?>,<?= $d->Level9;?>,<?= $d->Level10;?>,<?php endif;?><?php if($com_params->get("BinarySystem")):?><?= $d->BinaryIncome;?>,<?= $d->FutureBinary;?>,<?php endif;?><?php if($com_params->get("PlanHasSurveyIncome")):?><?= $d->SurveyIncome;?>,<?php endif;?><?= $d->ClosingAmount;?>,<?= $d->ClosingTDSAmount;?>,<?= $d->ClosingServiceCharge;?>,<?= $d->OtherDeductions;?>,<?= $d->OtherDeductionRemarks;?>,<?= $d->FirstPayoutDeduction;?>,<?= $d->ClosingAmountNet;?>,<?= $d->ClosingCarriedAmount;?>,<?= $d->distributor->details->Bank;?>,<?= $d->distributor->details->IFSC;?>,<?= $d->distributor->details->AccountNumber;?>,<?= $d->ClosingUpgradationDeduction;;?>,<?= $d->distributor->details->PanNo;?><?= "\n"?>
<?php endforeach; ?>