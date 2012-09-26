<?php $this->jq->useGraph();?>
<table width="100%" class="adminlist">
    <thead>
        <tr>
            <th class="title" width="10">#</th>
            <th class="title">Kit Name</th>
            <th class="title">Total Joining</th>
        </tr>
    </thead>
    <tbody>
        <?php
        jimport('joomla.html.html');
        $i = 1;
        foreach ($result as $res):?>
        <tr class="row<?php echo $i % 2 ?>">
            <td><?php echo $i;$i++; ?></td>
            <td><?php echo $res->ForKit; ?></td>
            <td><?php echo $res->Joinings; ?></td>
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
                $data_url = "index.php?option=com_mlm&format=raw&task=kits_cont.kitWiseGraphData&startdate=$start&enddate=$end";
                $this->jq->getGraphObject('100%', '200', $data_url, 'test_div');
                ?>
            </td>
            <td>
                wait
            </td>
        </tr>
    </tbody>
</table>