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
    <th>RMB</th>
    <th>L1</th>
    <th>L2</th>
    <th>L3</th>
    <th>L4</th>
    <th>L5</th>
    <th>L6</th>
    <th>L7</th>
    <th>L8</th>
    <th>L9</th>
    <th>L10</th>
    <th>Last Carried Amt</th>
    <th>Total Income</th>
    <th>TDs</th>
    <th>Service Charge</th>
    <th>Net Payable</th>
    <th>Carry Frwd.</th>
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
        <td><?php echo $cl->RMB?></td>
        <td><?php echo $cl->Level1?></td>
        <td><?php echo $cl->Level2?></td>
        <td><?php echo $cl->Level3?></td>
        <td><?php echo $cl->Level4?></td>
        <td><?php echo $cl->Level5?></td>
        <td><?php echo $cl->Level6?></td>
        <td><?php echo $cl->Level7?></td>
        <td><?php echo $cl->Level8?></td>
        <td><?php echo $cl->Level9?></td>
        <td><?php echo $cl->Level10?></td>
        <td><?php echo $cl->LastClosingCarryAmount?></td>
        <td><?php echo $cl->ClosingAmount?></td>
        <td><?php echo $cl->ClosingTDSAmount?></td>
        <td><?php echo $cl->ClosingServiceCharge?></td>
        <td><?php echo $cl->ClosingAmountNet?></td>
        <td><?php echo $cl->ClosingCarriedAmount?></td>
        <?php if($com_params->get("PrintStatement")):?>
        <td><a href="index.php?option=com_mlm&task=distributor_cont.printstatement&format=raw&statement=<?php echo $cl->id?>" target="_statement">Print</a></td>
        <?php endif;?>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>