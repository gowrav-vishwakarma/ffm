<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<br />
<br />
<table width="100%" border="1">
    <tr>
      <th height="38" colspan="3"> <p align="center"><span style="font-size: 24px">
    <?php
        $conf =& JFactory::getConfig();
        echo $conf->getValue( 'config.sitename' );
    ?>
      </span><br /><br />
  5, Tagore Nagar, Sector-4, Hiran Magri, Udaipur (Raj.)<br />
      Contact No : +91 8824248606, 8829029083
      <br />
          <?php echo $cd->details->Address ; ?><br />
          <br />
          Mobile No:    <?php echo $cd->details->MobileNo; ?><br />
     </p></th>
      </tr>
    <tr>
      <td colspan="2"><div align="left" style="font-size: 16px"><strong>To:</strong> <?=$cd->details->Name; ?> &nbsp;&nbsp;<strong>ID</strong>&nbsp;&nbsp;<?= $cd->id ?></div></td>
      <td>Invoice No: <span style="font-size: 16px"><?php echo $cd->id - 11500 ; ?></span></td>
      </tr>
    <tr>
      <td height="85" colspan="3" style="font-size: 18px">Received a sum of Rs <?= $cd->kit->MRP ?>/- from Distributor against product.</td>

      </tr>
    <tr>
      <th>Note</th>
      <td><strong>product once sold will not be taken back.<br />
        subject to Udaipur jurisdiction.      </strong></td>
      <td>Joining Date:<span style="font-size: 16px"><?= $cd->JoiningDate ?></span></td>

      </tr>
    <tr>
      <th colspan="3">This is computer generated Invoice hence no signature required</th>
      </tr>
  </table>
<?php
if(JRequest::getVar("format")!="raw"){
?>
<a href="index.php?option=com_mlm&task=distributor_cont.paymentreceipt&format=raw" target="vfghvf">Print</a>
<?php }
?>
