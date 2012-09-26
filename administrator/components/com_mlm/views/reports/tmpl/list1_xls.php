<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
global $com_params;
$i=1;
$sdate=strtotime($sdate);
$edate=strtotime($edate);
if($tableNo==1)
{
    $Norewards=6;
}
elseif($tableNo==2)
{
    $Norewards=4;
}
else
{
    $Norewards=10;
}
echo "S No,ID,Name,Joining date,";
for($i=1;$i<=$Norewards;$i++)
{
    echo "Reward$i,";
}
echo "\n";
$j=0;
foreach($results as $d):
    echo "$j,$d->did,$d->name,$d->jd,";            
    for($i=1;$i<=$Norewards;$i++){                 
        $reward="r".$i;
        if( $sdate<=strtotime($d->{$reward}) && $edate>=strtotime($d->{$reward}))
        {
            echo $d->{$reward}.",";
        }
        else
            echo "---,";
    }            
    echo "\n";
    $j++;
endforeach;
?>