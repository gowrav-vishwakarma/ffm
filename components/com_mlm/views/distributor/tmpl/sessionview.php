<?php
global $com_params;
$i=1;
?>
<table width="100%" border="0" cellpadding="3" class="ui-widget">
<tr class="ui-widget-header">
  <th>S.No</th>
  <th>Session</th>
  <th>Session Left PV</th>
  <th>Session Right PV</th>
  <th>Session Left Count</th>
  <th>Session Right Count</th>
  <?php if($com_params->get('PlanHasIntroductionIncome')):?>
            <th>Session Intros</th>
  <?php endif; ?>
  <th>Session Pair</th>
</tr>
<?php foreach($cd->sessionclosings as $s) :?>
<tr class="ui-widget-content">
  <td align="center"><?= ++$i;?></td>
  <td align="center"><?= $s->Session;?></td>
  <td align="center"><?= $s->SessionLeftPV;?></td>
  <td align="center"><?= $s->SessionRightPV;?></td>
  <td align="center"><?= $s->SessionLeftCount;?></td>
  <td align="center"><?= $s->SessionRightCount;?></td>
  <?php if($com_params->get('PlanHasIntroductionIncome')):?>
         <td align="center"><?= $s->SessionIntros;?></td>
  <?php endif; ?>
  <td align="center"><?= $s->SessionPairPV?></td>
</tr>
<?php endforeach;?>
</table>
<h3>Current Session Condition</h3>
<?php
    $cd->legs->get();
?>
<table width="100%" border="0" cellpadding="3" class="ui-widget">
<tr class="ui-widget-header">
  <th>Leg</th>
  <th>Previous Carried + Session PV</th>
</tr>
<?php
foreach($cd->legs as $l):
?>
<tr class="ui-widget-content">
   <td align="center"><?= $l->Leg;?></td>
  <td align="center"><?= $l->SessionPV;?></td>
</tr>
<?php endforeach;?>
</table>