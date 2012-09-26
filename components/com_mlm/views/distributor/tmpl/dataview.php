<?php 
global $com_params;
$c=new xConfig('distributor_area');
?>
<table width="100%" border="0" cellpadding="3">
<tr></tr>
<tr>
  <th>S.No</th>
  <th>ID</th>
  <th>Name</th>
  <th>Sponsor</th>
  <th>Leg</th>
  <?php if($com_params->get('PlanHasIntroductionIncome')) :  ?>
  <th>Introducer ID</th>
  <?php endif;?>
  <?php if($c->getkey('ContactNumberInDataView')) :  ?>
  <th>Mobile Number</th>
  <?php endif;?>
  <th>&nbsp;</th>
</tr>
<?php foreach($result as $cd) :?>
<?php $cd=new Distributor($cd->id);?>
<tr>
  <td align="center"><?= ++$i;?></td>
  <td align="center"><?= $cd->id;?></td>
  <td><?= $cd->details->Name;?></td>
  <td align="center"><?= $cd->sponsor->id;?></td>
  <td align="center"><?= substr($cd->Path,  strlen($cd->Path) - 1);?></td>
  <?php if($com_params->get('PlanHasIntroductionIncome')) :  ?>
  <td align="center"><?= $cd->introducer->id;?></td>
  <?php endif;?>
  <?php if($c->getkey('ContactNumberInDataView')) :  ?>
  <td align="center"><?= $cd->details->MobileNo;?></td>
  <?php endif;?>
  <td>&nbsp;</td>
</tr>
<?php endforeach;?>
</table>
<?php $x = ($start-$count) < 0 ? 0 : ($start-$count);
      $y = ($start+$count) > $i ? $start : ($start+$count);
?>
<p><a href="<?= site_url()."?option=com_mlm&task=distributor_cont.dataview&Itemid=".JRequest::getVar('Itemid')."&pagestart=$x" ?>">Previous</a>
  <a href="<?= site_url()."?option=com_mlm&task=distributor_cont.dataview&Itemid=".JRequest::getVar('Itemid')."&pagestart=$y" ?>">Next</a><p>
