<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$c = new xConfig("distributor_area");
$pinManagerAccess = $c->getKey("PinManagerPasswordProtected");
if ($pinManagerAccess == 1){
    echo $form2;
    echo "<br>";
}
echo $tabs;
?>
