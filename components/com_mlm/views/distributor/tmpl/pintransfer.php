<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($pts);
$cd = new Distributor();
$cd->getCurrent();
echo "<table width='100%' border='1'><tr><td><b>From</b><td><b>To</b></td><td><b>Movement</b></td><td><b>Pins</b></td><td><b>Date</b></td></tr>";
foreach($pts as $pt){
    echo "<tr><td><b>$pt->Fromdistributor_id</b><td><b>$pt->Todistributor_id</b></td><td><b>";
    if($pt->Fromdistributor_id==$cd->id)
        echo "Sent</b></td><td>$pt->Narration</td><td>$pt->created_at</td></tr>";
    else
        echo "Received</b></td><td>$pt->Narration</td><td>$pt->created_at</td></tr>";
}
echo "</table>";
?>