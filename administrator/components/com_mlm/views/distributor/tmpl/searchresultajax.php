<table width="100%" class="adminlist">
    <thead>
        <tr>
            <th class="title">ID</th>
            <th class="title">Name</th>
            <th class="title">Kit</th>
            <th class="title">SponsorID</th>
            <th class="title">IntroducerID</th>
            <th class="title">Address</th>
            <th class="title">Mobile No</th>
            <th class="title">Pan No</th>
            <th class="title">Joining Date</th>
            <th class="title">??</th>
        </tr>
    </thead>
    <tbody>
       <?php
        jimport('joomla.html.html');
        $i = 0;
        foreach ($result as $d) :
            $id = JHTML::_('grid.id', ++$i, $d->id);
        ?>
            <tr class="row<?php echo $i % 2 ?>">
                <td><?php echo $d->distributor_id; ?></td>
                <td><?php echo $d->Name; ?></td>
                <td><?php echo $d->detailsof->kit->Name; ?></td>
                <td><?php echo $d->detailsof->sponsor_id; ?></td>
                <td><?php echo $d->detailsof->introducer_id; ?></td>
                <td><?php echo substr($d->Address, 0, 20). ".."; ?></td>
                <td><?php echo $d->MobileNo; ?></td>
                <td><?php echo $d->PanNo; ?></td>
                <td><?php echo $d->detailsof->JoiningDate; ?></td>
                <td><a href="index.php?option=com_mlm&task=admindistributor_cont.distributorActionPage&did=<?php echo $d->distributor_id; ?>">??</a></td>
            </tr>
       <?php
            endforeach;
        ?>
    </tbody>
</table>