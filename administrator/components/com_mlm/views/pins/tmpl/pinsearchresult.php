<table width="100%" class="adminlist false">
    <thead>
        <tr>
            <th class="title">DistributorID</th>
            <th class="title">PIN</th>
            <th class="title">Kit</th>
            <th class="title">Published</th>
            <th class="title">AllotedTo</th>
        </tr>
    </thead>
    <tbody>
       <?php
        jimport('joomla.html.html');
        $i = 0;
        foreach ($searchedpins as $pin) :
            $id = JHTML::_('grid.id', ++$i, $pin->id);
            $published = JHTML::_('grid.published', $pin, $i);
        ?>
            <tr class="row<?php echo $i % 2 ?>">
                <td><?php echo $pin->id; ?></td>
                <td><?php echo $pin->Pin; ?></td>
                <td><?php echo $pin->kit->Name; ?></td>
                <td align="center"><?php echo $published ?></td>
                <td><?php echo $pin->adcrd_id; ?></td>
            </tr>
       <?php
            endforeach;
        ?>
    </tbody>
</table>