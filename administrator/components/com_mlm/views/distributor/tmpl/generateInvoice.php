<?php
	$tax=10;
?><script language="javascript" type="text/javascript">
    <!--
    var flag = false;
    var flag_6 = false;

    var arr_unit = new Array("","One","Two","Three","Four","Five","Six","Seven","Eight","Nine");

    var arr_hundred = new Array("","Ten","Twenty","Thirty","Forty","Fifty","Sixty","Seventy","Eighty","Ninety");

    var arr_spl = new Array("","Eleven","Twelve","Thirteen","Fourteen","Fifteen","Sixteen","Seventeen","Eighteen","Nineteen");

    function getAmountInWords(str_amount)
    {
        var str_part = "";
        var str_returnvalue = "";
        var str_words_rs = "";
        var str_words_ps = "";
        var str_token_1 = "";
        flag_6 = false;

        if (parseFloat(str_amount) == 0){
            return " Zero ";
        }
        else
            if (str_amount.substr(0,1) == '0'){
                //alert("Please Enter valid Amount");
            }
        else
        {
            var ind = str_amount.indexOf(".");

            if (ind != -1)
            {
                str_token_1 = str_amount.substring(0,ind);
                str_token_2 = str_amount.substring(ind+1,str_amount.length);

                if (str_token_2.length == 1)
                    str_token_2 = str_token_2 + "0";

            }
            else
            {
                str_token_1 = str_amount;
                str_token_2 = "";
            }



            for (var i=0;i<str_token_1.length;i++)
            {
                str_part = str_token_1.substring(i,str_token_1.length);

                str_returnvalue = getWords(str_part);

                if (str_returnvalue != "")
                    str_words_rs += str_returnvalue + " ";

                if (flag)
                    i++;
            }

            if (str_token_2 != "" && str_token_2 != "00")
            {
                for (var i=0;i<str_token_2.length;i++)
                {
                    str_part = str_token_2.substring(i,str_token_2.length);

                    str_returnvalue = getWords(str_part);

                    if (str_returnvalue != "")
                        str_words_ps += str_returnvalue + " ";

                    if (flag)
                        i++;
                }
            }

            if (str_token_2 != "" && str_token_2 != "00")
                myamount = " " + str_words_rs + " And "+str_words_ps + "Paise" + " Only";
            else
                myamount = " "+ str_words_rs + " Only";
        }
        return myamount;
    }//end function getAmountInWords(str_amount)


    function getWords(str_part)
    {
        var val_1 = "";
        var val_2 = "";
        var str_returnvalue = "";
        flag = false;

        var k = str_part.length;

        switch(k)
        {
            case 0 :

            case 1 :
                val_1 = parseInt(str_part.substr(0,1));
                str_returnvalue = arr_unit[val_1];
                break;

            case 2 :
                val_1 = parseInt(str_part.substr(0,1));
                val_2 = parseInt(str_part.substr(1,1));

                if (val_1 == 1 && val_2 != 0)
                {
                    str_returnvalue = arr_spl[val_2];
                    flag = true;
                }
                else
                    str_returnvalue = arr_hundred[val_1];

                break;

            case 3 :
                val_1 = parseInt(str_part.substr(0,1));

                if (val_1 == 0)
                    str_returnvalue = "";
                else
                    str_returnvalue = arr_unit[val_1] + " " + "Hundred";
                break;

            case 4 :
                val_1 = parseInt(str_part.substr(0,1));

                if (val_1 == 0 && flag_6 == true)
                    str_returnvalue = arr_unit[val_1] ;
                else
                    str_returnvalue = arr_unit[val_1] + " " + "Thousand";

                break;

            case 5 :
                val_1 = parseInt(str_part.substr(0,1));
                val_2 = parseInt(str_part.substr(1,1));

                if (val_1 == 1 && val_2 != 0)
                {
                    str_returnvalue = arr_spl[val_2] + " " +"Thousand";
                    flag = true;
                }
                else
                {
                    str_returnvalue = arr_hundred[val_1];

                }
                break;

            case 6 :
                val_1 = parseInt(str_part.substr(0,1));
                val_2 = parseInt(str_part.substr(1,1));

                str_returnvalue = arr_unit[val_1] + " " + "Lakh";

                if (val_2 == 0)
                    flag_6 = true;

                break;

            case 7 :
                val_1 = parseInt(str_part.substr(0,1));
                val_2 = parseInt(str_part.substr(1,1));

                if (val_1 == 1 && val_2 != 0)
                {
                    str_returnvalue = arr_spl[val_2] + " " +"Lakh";
                    flag = true;
                    flag_6 = true;
                }
                else
                {
                    str_returnvalue = arr_hundred[val_1];
                }

                break;


        }//end switch

        return str_returnvalue;

    }//end function getWords(str_part)



    function checkNum(newObj)
    {
        var flag = true;

        var v_value = newObj.value;

        for (var i=0;i<v_value.length;i++)
        {
            var v_part = v_value.substring(i,i+1);
            if (v_part == "e" || v_part == "E")
            {
                alert("Please enter numeric values");
                newObj.value = '0.00';
                newObj.focus();
                newObj.select();

                flag =  false;
            }
        }

        if (v_value == "")	{
            alert("Please enter positive numeric values");
            newfield.value = "0.00";
            newfield.focus();
            newfield.select();

            return false ;
        }
        else
            if (isNaN(v_value) || v_value <= 0)	{
                alert("Please enter positive numeric values");
                newObj.value = "0.00";
                newObj.focus();
                newObj.select();

                flag =  false;
            }
        return flag;
    }


    function checkForDecimalInAmount(newObj)
    {
        var leftPart;
        var rightPart;
        var idOfDecimal;

        var val = newObj.value;
        var len = val.length;

        if (val.indexOf('.') == -1)
        {
            if (len > 7)
            {
                alert('Amount too large');
                newObj.value = '0.00';
                newObj.focus();
                newObj.select();

                return false;
            }

        }
        else
        {
            idOfDecimal = val.indexOf('.');

            leftPart = val.substring(0,idOfDecimal);

            rightPart = val.substring(idOfDecimal+1,val.length);


            if (leftPart.length > 7)
            {
                alert('Amount too large');
                newObj.value = '0.00';
                newObj.focus();
                newObj.select();

                return false;
            }

            if (rightPart.length > 2)
            {
                alert('Only 2 digits after decimal is allowed');
                newObj.value = '0.00';
                newObj.focus();
                newObj.select();

                return false;
            }

        }

        return true;
    }//end function checkForDecimalInAmount()

    //-->


</script><style type="text/css">
<!--
.CamelCase {
	text-transform: capitalize;
}
-->
</style><table width="100%" border="1" cellpadding="3">
  <tr>
    <td colspan="5" align="center"><h2>FAMILY FUTURE BUSINESS</h2>
    <p>Address Family Future Business</h1>
        <p>A53, Lucky Mension, Opp. Hansa Palace,
Sector - 4, Hiran Magri Main Road, Udaipur (Raj.)<br />
      Phone no:+91 8824248606 email:  familyfuture.business@gmail.com,info@familyfuturebusiness.in    </p></td>
  </tr>
  <tr>
    <td colspan="5" align="center">INVOICE</td>
  </tr>
  <tr>
    <td colspan="3" valign="top" class="CamelCase"><?php echo $cd->detail->Name ?>&nbsp;</td>
    <td colspan="2"><table width="100%" border="0">
      <tr>
        <td><strong>Bill No: <?php echo $cd->id; ?></strong></td>
        <td>Dated: <?php echo date("d-M-Y",strtotime($cd->JoiningDate)); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="39%"><div align="center"><strong>PARTICULARS</strong></div></td>
    <td width="11%"><div align="center"><strong>QTY</strong></div></td>
    <td width="8%"><div align="center"><strong>UNIT</strong></div></td>
    <td width="26%"><div align="center"><strong>RATE</strong></div></td>
    <td width="16%"><div align="center"><strong>AMOUNT</strong></div></td>
  </tr>
  <tr>
    <td height="192" valign="top">Hotel Room Booking .. bla blabla</td>
    <td align="center" valign="top">1.00</td>
    <td align="center" valign="top">Pcs.</td>
    <td valign="top">
    <?php
		$rate=round(($cd->kit->MRP * 100) / (100+ $tax),2);
		echo $rate;
	?>
    </td>
    <td valign="top"><?php echo $rate;?></td>
  </tr>
  <tr>
    <td align="right"><strong>Total</strong></td>
    <td align="center">1.00</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="right"><strong>Taxes</strong></div></td>
    <td>@<?php echo $tax;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo round($tax * $rate / 100.00,2);?></td>
  </tr>
  <tr>
    <td height="23">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="right"><strong>NET AMOUNT</strong></div></td>
    <td><?php echo $cd->kit->MRP;?></td>
  </tr>
  <tr>
    <td height="23" colspan="5">Amount In Words: <script language="javascript" type="text/javascript">
                        document.write (getAmountInWords("<?php echo sprintf("%01.2f", round($cd->kit->MRP, 0)); ?>"));
                        </script></td>
  </tr>
</table>