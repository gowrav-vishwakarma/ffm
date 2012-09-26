<form action="index.php" method="get" name="adminForm" id="adminForm">
    <input type="hidden" name="boxchecked" value="0">
    <input type="hidden" name="task">
    <input type="hidden" name="hidemainmenu">
    <input type="hidden" name="option" value="<?php echo JRequest::getVar('option') ?>">
</form> 
<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$this->load->helper('directory');

$files = $map = directory_map('components/com_mlm/config', true);
?>
<div class="ui-widget ui-widget-header ui-corner-all">
    <table>
        <tr>
           <?php
            foreach ($files as $file) {
                if (strpos($file, "xml")) {
                    $file = explode(".", $file);
                    $file = $file[0];
            ?>
                    <td width="8px"></td>        
                    <td><h3><a href="index.php?option=com_mlm&task=config_cont.edit&config=<?php echo $file ?>"><?php echo $file; ?></a></h3></td>

           <?php
                }
            }
            ?>

        </tr>
    </table>
</div>