<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
JHTML::_('behavior.tooltip');
?>
<script language="JavaScript" type="text/javascript">
    function treeModify(ID){
        if(ID!=0){
            document.getElementById("Start").value=ID;
            document.TreeID.submit(true);
        }
    }
</script>
<div align="center" class="ui-widget ui-corner-all">
    <div class="dtree ui-widget ui-corner-all" align="center" style="background-color:#E8F0E6; width:100%; height:400px; overflow:auto; background-position:center">
        <script type="text/javascript"  language=javascript>
            mytree = new dTree('mytree','images/treeimg/');
<?php

function drawChildrenOf($id, $level, $configtreelevels) {
    global $com_params;
    if ($level == $configtreelevels)
        return;
    $id->legs->get();
    foreach ($id->legs as $l) {
        $cdd = new Distributor($l->downline_id);
        $clr = ($cdd->TotalUpgradationDeduction + $cdd->ClosingUpgradationDeduction >= 8000) ? "green" : "blue";
        if ($com_params->get('ShowRedPinsInRed'))
            $folder = "images/treeimg/folder_" . (($cdd->kit->DefaultGreen == 1) ? $clr : "red") . ".gif";
        else
            $folder="images/treeimg/folder_".$clr.".gif";
        $folderopen = $folder;
        echo "mytree.add(" . $cdd->id . ",$id->id, '  [" . $cdd->detail->Name . "] <br>" . $cdd->id . "[" . substr($cdd->Path, -1) . "] ', 'javascript:treeModify(" . $cdd->id . ")', '" . $cdd->detailsOf(true) . "', '', '" . $folder . "','" . $folderopen . "','','" . $cdd->detail->Name . "');\n";
        $temp = new Distributor();
        $temp->get_by_id($l->downline_id);
        drawChildrenOf($temp, $level + 1, $configtreelevels);
    }
}

$tree = array();
global $com_params;
$clr = ($cd->TotalUpgradationDeduction + $cd->ClosingUpgradationDeduction >= 8000) ? "green" : "blue";
if ($com_params->get('ShowRedPinsInRed'))
    $folder = "images/treeimg/folder_" . (($cd->kit->DefaultGreen == 1) ? $clr : "red") . ".gif";
else
    $folder="images/treeimg/folder_".$clr.".gif";
$folderopen = $folder;
echo "mytree.add(" . $cd->id . ", -1, '  [" . $cd->detail->Name . "] <br>" . $cd->id . "[" . substr($cd->Path, -1) . "] ', 'javascript:treeModify(" . $cd->id . ")', '" . $cd->detailsOf(true) . "', '', '" . $folder . "','" . $folderopen . "','','" . $cd->detail->Name . "');\n";

drawChildrenOf($cd, 0, $configtreelevels);
?>
    document.write(mytree);

        </script>
    </div>
    <div><a href="javascript:treeModify(<?php echo $cd->sponsor_id?>)">Go UP</a></div>
    <form action="index.php?option=com_mlm&task=distributor_cont.treeview&Itemid=4" method="post" name="TreeID" id="TreeID">
    <input name="Start" type="text" id="Start" />
    <input type="submit" value="GO">
</form>
</div>