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
    <th>Intro Income</th>
    <th>Binary Income</th>
    <th>Survey Income</th>
    <th>Total Income</th>
    <th>TDs</th>
    <th>Service Charge</th>
    <th>Net Payable</th>
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
        <td><?php echo $cl->IntroductionAmount?></td>
        <td><?php echo $cl->BinaryIncome?></td>
        <td><?php echo $cl->SurveyIncome?></td>
        <td><?php echo $cl->ClosingAmount?></td>
        <td><?php echo $cl->ClosingTDSAmount?></td>
        <td><?php echo $cl->ClosingServiceCharge?></td>
        <td><?php echo $cl->ClosingAmountNet?></td>
        <?php if($com_params->get("PrintStatement")):?>
        <td><a href="index.php?option=com_mlm&task=distributor_cont.printstatement&format=raw&statement=<?php echo $cl->id?>" target="_statement">Print</a></td>
        <?php endif;?>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>