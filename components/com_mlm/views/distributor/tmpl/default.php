<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
global $com_params;
?>
<table class="ui-widget">
    <tr>
        <th>Welcome</th>
        <td><?php echo $cd->detail->Name; ?></td>
    </tr>
    <tr>
        <th>Sponsor</th>
        <td><?php echo $cd->sponsor->id . " [ " . $cd->sponsor->detail->Name ." ]";?></td>
    </tr>
    <?php if($com_params->get('PlanHasIntroductionIncome')):?>
    <tr>
        <th>Introducer</th>
        <td><?php echo $cd->introducer->id . " [ " . $cd->introducer->detail->Name ." ]";?></td>
    </tr>
    <?php endif;?>
    <tr>
        <th>Joining Kit</th>
        <td><?php echo $cd->kit->Name;?></td>
    </tr>
</table>
<?php
    echo $cd->detailsOf(false);
?>