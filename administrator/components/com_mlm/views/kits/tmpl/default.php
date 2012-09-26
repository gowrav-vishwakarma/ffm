<?php $this->jq->useGraph();?>
<table width="100%" class="adminlist">
    <thead>
        <tr>
            <th class="title" width="10">#</th>
            <th class="title">Kit Name</th>
            <th class="title">MRP / DP</th>
            <th class="title">Introduction Amount</th>
            <th class="title">BV</th>
            <th class="title">PV</th>
            <th class="title">RP</th>
            <th class="title">Capping</th>
            <th class="title">Green Joining</th>
            <th class="title">Published</th>
            <th class="title">Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php
        jimport('joomla.html.html');
        $i = 0;
        foreach ($kits as $kit) :
            $id = JHTML::_('grid.id', ++$i, $kit->id);
            $published = JHTML::_('grid.published', $kit, $i);
        ?>
            <tr class="row<?php echo $i % 2 ?>">
                <td><?php echo $kit->id; ?></td>
                <td><?php echo $kit->Name; ?></td>
                <td><?php echo $kit->MRP . " / " . $kit->DP; ?></td>
                <td width="15"><?php echo $kit->AmountToIntroducer ?></td>
                <td width="15"><?php echo $kit->BV ?></td>
                <td width="15"><?php echo $kit->PV ?></td>
                <td width="15"><?php echo $kit->RP ?></td>
                <td width="15"><?php echo $kit->Capping ?></td>
                <td width="15"><?php echo ($kit->DefaultGreen == 1) ? "" : "NO"; ?></td>
                <td align="center"><?php echo $published ?></td>
                <td class="title"><a title="Edit kit<?php echo $kit->Name; ?>" href="index.php?option=com_mlm&task=kits_cont.edit&kitid=<?php echo $kit->id; ?>&format=raw" class="alertinwindow">Edit</a></td>
            </tr>
        <?php
            endforeach;
        ?>
        </tbody>
    </table>
    <table width="100%" class="adminlist">
        <thead>
            <tr>
                <th class="title" width="50%">Kit Wise</th>
                <th class="title">Kit Name</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                <?php
//open_flash_chart_object( 300, 200, "index.php?option=com_mlm&format=raw&task=ofc2.get_data_bar", false );
                $data_url = "index.php?option=com_mlm&format=raw&task=kits_cont.kitWiseGraphData";
                $this->jq->getGraphObject('100%', '200', $data_url, 'test_div');
                ?>
            </td>
            <td>
                wait
            </td>
        </tr>
    </tbody>
</table>