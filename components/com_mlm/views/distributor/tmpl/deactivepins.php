<table width="100%" border="0" cellpadding="3">
<tr></tr>
<tr>
  <th>S.No</th>
  <th>Distributor ID</th>
  <th>Distributor Name</th>
  <th>Pin</th>
  <th>Kit Name</th>
</tr>
<?php $i=0;?>
<?php foreach($result as $r) :?>
<?php if($r->published != 1) :?>
<?php //$dt=new Distributor($r->id);?>
<tr>
  <td><?= ++$i;?></td>
  <td><?= $r->id;?></td>
  <td><? //$dt->details->Name;?></td>
  <td><?= $r->Pin;?></td>
  <td><?= $r->Name;?></td>
</tr>
<?php endif;?>
<?php endforeach;?>
</table>
<?php $x = ($start-$count) < 0 ? 0 : ($start-$count);
      $y = ($start+$count) > $i ? $start : ($start+$count);
?>
