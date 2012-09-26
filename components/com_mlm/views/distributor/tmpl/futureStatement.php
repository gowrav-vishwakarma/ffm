<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
global $com_params;
$cd->closings->get();
$i=1;
?>
<table class="ui-widget" width="100%" border="1">
    <thead>
        <tr class="ui-widget-header">
    <th>Sno</th>
    <th>Closing</th>
    <th>Last Carried</th>
    <th>Binary Income</th>
    <th>F Bin Income</th>
    <th>Total Income</th>
    <th>Req. Deductions</th>
    <th>Service Charge</th>
    <th>Upgrd Deduction</th>
    <th>Social Deduction</th>
    <th>First Deduction</th>
    <th>Net Payable</th>
    <th>Carry Frwd</th>
    <?php if($com_params->get("PrintStatement")):?>
    <th>Print</th>
    <?php endif;?>
        </tr>
</thead>
<tbody>
    <?php foreach ($cd->closings as $cl): ?>
    <tr class="ui-widget-content" align="center">
        <td><?php echo $i++;?></td>
        <td><?php echo $cl->closing?></td>
        <td><?php echo $cl->LastClosingCarryAmount?></td>
        <td><?php echo $cl->BinaryIncome?></td>
        <td><?php echo $cl->FutureBinary?></td>
        <td><?php echo $cl->ClosingAmount?></td>
        <td><?php echo $cl->ClosingTDSAmount?></td>
        <td><?php echo $cl->ClosingServiceCharge?></td>
        <td><?php echo $cl->ClosingUpgradationDeduction?></td>
        <td><?php echo $cl->OtherDeductions?></td>
        <td><?php echo $cl->FirstPayoutDeduction?></td>
        <td><?php echo $cl->ClosingAmountNet?></td>
        <td><?php echo $cl->ClosingCarriedAmount?></td>
        <?php if($com_params->get("PrintStatement")):?>
        <td><a href="index.php?option=com_mlm&task=distributor_cont.printstatement&format=raw&statement=<?php echo $cl->id?>" target="_statement">Print</a></td>
        <?php endif;?>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>