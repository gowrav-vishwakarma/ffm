<table width="100%" class="ui-widget">
    <thead>
        <tr class="ui-widget-header">
            <th class="title">ID</th>
            <th class="title">Survey</th>
            <th class="title">Point</th>
            <th class="title">Type</th>
            <th class="title">Take Survey</th>
        </tr>
    </thead>
    <tbody>
       <?php
        jimport('joomla.html.html');
        $i = 0;
        foreach ($surveys as $s) :
            $id = JHTML::_('grid.id', ++$i, $s->id);
            $sd=new DistributorSurveys();
            $sd->where('survey_id',$s->id)->where('distributor_id',$cd->id)->get();
            $done=$sd->result_count();
        ?>
            <tr class="row<?php echo $i % 2 ?> ui-widget-content">
                <td><?php echo $s->id; ?></td>
                <td><?php echo $s->Title; ?></td>
                <td><?php echo $s->Points; ?></td>
                <td><?php echo $s->Type; ?></td>
                <?php if(!$done):?>
                <td><a title="Survey For <?php echo $s->Title;?>" class="alertinwindow" href="index.php?option=com_mlm&task=distributor_cont.takeSurvey&sid=<?php echo $s->id; ?>&format=raw">View Ad</a></td>
                <?php else:?>
                <td>Already Taken</td>
                <?php endif;?>
            </tr>
       <?php
            endforeach;
        ?>
    </tbody>
</table>