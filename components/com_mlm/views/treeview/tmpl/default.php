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
<form action="index.php?option=com_mlm&task=distributor_cont.treeview&Itemid=4" method="post" name="TreeID" id="TreeID">
    <input name="Start" type="hidden" id="Start" />
</form>