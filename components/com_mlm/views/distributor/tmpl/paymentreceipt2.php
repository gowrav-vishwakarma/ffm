<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 if(JRequest::getVar("format")=="raw"){ ?>
 <script language="javascript" type="application/javascript">
 window.print() ;
 </script>
<?php 	 
 }
?>
<table width="100%" border="1" cellpadding="3">
  <tr>
    <td>
    <table width="100%" border="0">
    <tr>
      <td height="38" colspan="3"> <p align="center"><span style="font-size: 24px">
    <?php
        $conf =& JFactory::getConfig();
        echo $conf->getValue( 'config.sitename' );
    ?>
      </span><br />
      
      <br />
      <span style="font-size: 24px">
      <?php
        $conf =& JFactory::getConfig();
        echo $conf->getValue( 'config.address' );
    ?>
      </span></p></td>
    </tr>
    <tr>
      <td width="20%" colspan="2">&nbsp;</td>
      <td width="80%"><p align="right">Date: <span style="font-size: 16px">
      <?= getNow(); ?>
      </span><br />
        <br />
      </p></td>
    </tr>
    <tr>
      <th colspan="2"><div align="left">Receipt No:-</div></th>
      <td><span style="font-size: 16px"><?php echo $cd->id - 11500 ; ?></span></td>
    </tr>
    <tr>
      <th colspan="2"><div align="left">Member Name :-</div></th>
      <td><span style="font-size: 16px">
        <?=$cd->details->Name; ?>
      </span></td>
    </tr>
    <tr>
      <th colspan="2"><div align="left">Date Of Joining :-</div></th>
      <td><span style="font-size: 16px">
        <?=$cd->JoiningDate; ?>
      </span></td>
    </tr>
    <tr>
      <th colspan="2"><p align="left">User-ID :-</p></th>
      <td><span style="font-size: 16px">
        <?= $cd->id ?>
      </span></td>
    </tr>
    <tr>
      <th colspan="2"><div align="left">Registration Amount :-</div></th>
      <td><span style="font-size: 18px">
        <?= $cd->kit->MRP ?>
      </span></td>
    </tr>
    <tr>
      <th colspan="2"><div align="left"></div></th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th colspan="3">This is computer generated Invoice hence no signature required</th>
      </tr>
  </table>

    
    </td>
  </tr>
</table>

  <a href="index.php?option=com_mlm&task=distributor_cont.paymentreceipt&format=raw" target="_statementprint">print</a>
