<?php header("Content-Type: application/force-download\n"); ?>
DistributorID,PIN,Kit,Published,AllotedTo
       <?php
        jimport('joomla.html.html');
        $i = 0;
        foreach ($searchedpins as $pin) :
            $id = JHTML::_('grid.id', ++$i, $pin->id);
        ?>
<?php echo $pin->id; ?>,<?php echo $pin->Pin; ?>,<?php echo $pin->kit->Name; ?>,<?php echo $pin->published ?>,<?php echo $pin->adcrd->id; ?><?php echo "\n"?>
       <?php
            endforeach;
        ?>