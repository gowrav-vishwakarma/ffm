<table width="100%" border="0" cellpadding="3">
<tr></tr>
<tr>
  <th>S.No</th>
  <th>Distributor ID</th>
  <th>Pin</th>
  <th>Kit Name</th>
</tr>
<?php foreach($result as $r) :?>
<?php if($r->Used == 0 && $r->published == 1 ) :?>
<tr>
  <td><?= ++$i;?></td>
  <td><?= $r->id;?></td>
  <td><?= $r->Pin;?></td>
  <td><?= $r->Name;?></td>
</tr>
<?php endif;?>
<?php endforeach;?>
</table>
<?php $x = ($start-$count) < 0 ? 0 : ($start-$count);
      $y = ($start+$count) > $i ? $start : ($start+$count);
?>
<!--<p><a href="<?= site_url()."?option=com_mlm&task=distributor_cont.pinmanagerform&Itemid=".JRequest::getVar('Itemid')."&pagestart=$x" ?>">Previous</a>
  <a href="<?= site_url()."?option=com_mlm&task=distributor_cont.pinmanagerform&Itemid=".JRequest::getVar('Itemid')."&pagestart=$y" ?>">Next</a><p>-->
