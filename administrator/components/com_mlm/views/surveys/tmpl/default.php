<table width="100%" class="adminlist">
    <thead>
        <tr>
            <th class="title">ID</th>
            <th class="title">Survey</th>
            <th class="title">A</th>
            <th class="title">B</th>
            <th class="title">C</th>
            <th class="title">D</th>
            <th class="title">Correct</th>
            <th class="title">Type</th>
            <th class="title">StartDate</th>
            <th class="title">EndDate</th>
            <th class="title">Action</th>
        </tr>
    </thead>
    <tbody>
       <?php
        jimport('joomla.html.html');
        $i = 0;
        foreach ($surveys as $s) :
            $id = JHTML::_('grid.id', ++$i, $s->id);
        ?>
            <tr class="row<?php echo $i % 2 ?>">
                <td><?php echo $s->id; ?></td>
                <td><?php echo $s->Survey; ?></td>
                <td><?php echo $s->A; ?></td>
                <td><?php echo $s->B; ?></td>
                <td><?php echo $s->C; ?></td>
                <td><?php echo $s->D;; ?></td>
                <td><?php echo $s->Correct; ?></td>
                <td><?php echo $s->Type; ?></td>
                <td><?php echo $s->StartDate; ?></td>
                <td><?php echo $s->EndDate; ?></td>
                <td><a href="index.php?option=com_mlm&task=survey_cont.editSurvey&sid=<?php echo $s->id; ?>">??</a></td>
            </tr>
       <?php
            endforeach;
        ?>
    </tbody>
</table>