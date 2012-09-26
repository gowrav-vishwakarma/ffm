<?php
$cd = new Distributor($id);
$cd->get();
$distributor = $cd->detail;
?>


<script language="javascript" type="text/javascript">
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


</script>


<div align="center" ><h1 style="color:red">Family  Future Business Marketing Pvt. Ltd.</h1> <br>
    5, Tagore Nagar, Sector-4,
Hiran Magri, Udaipur (Raj.)</div>
<table border="1" cellpadding="0">
    <tr>
        <td><div align="center"><strong>Proforma    Invoice</strong> <br>
                Please    print this proforma invoice and send it along with your draft.<br>
                If you don't have a printer please write all this information on a paper and    send it along with your draft. </div></td>
    </tr>
    <tr>
        <td height="206" valign="top"><table border="1" cellspacing="1" cellpadding="0" width="100%">
                <tr>
                    <td width="17%"><p><strong>To&nbsp;: </strong> </p></td>
                    <td width="29%"><p><?= $distributor->Name ?> </p></td>
                    <td width="24%"><strong>Date Of Join &nbsp;: </strong></td>
                    <td width="30%"><?= date("d-M-Y", strtotime($cd->JoiningDate)); ?></td>
                </tr>
                <tr>
                    <td width="17%"><p><strong>S/o&nbsp;: </strong> </p></td>
                    <td width="29%"><p><?= $distributor->Father_HusbandName ?></p></td>
                    <td width="24%"><strong>Login Id&nbsp;: </strong></td>
                    <td width="30%"><?= $cd->id; ?></td>
                </tr>
                <tr>
                    <td width="17%"><p><strong>Address: </strong> </p></td>
                    <td width="29%"><p><?= $distributor->Address ?> </p></td>
                    <td width="24%"><strong>Date&nbsp;of Birth: </strong></td>
                    <td width="30%"><?= date("d-M-Y", strtotime($cd->Dob)); ?></td>
                </tr>
                <tr>
                    <td width="17%"><p><strong>City.:</strong> </p></td>
                    <td width="29%"><p><?= $distributor->City ?></p></td>
                    <td width="24%"><strong>Tel.&nbsp;No:</strong></td>
                    <td width="30%"><?= $cd->details->MobileNo; ?></td>
                </tr>
                <tr>
                    <td><p><strong>State.:</strong><strong> </strong></p></td>
                    <td width="29%"><p><?= $distributor->State ?></p></td>
                    <td width="24%"><strong>PAN/GIR No.</strong></td>
                    <td width="30%"><?= $cd->PanNo ? $cd->PanNo : "-"; ?></td>
                </tr>
                <tr>
                    <td><p><strong>PinCode:</strong></p></td>
                    <td width="29%"><p><?= $distributor->PinCode ?></p></td>
                    <td width="24%"><strong>Package</strong>:</td>
                    <td width="30%"><?= $cd->kit->Name; ?></td>
                </tr>
                <tr>
                    <td><p><strong>Reference ID:</strong></p></td>
                    <td width="29%"><p><?= $cd->sponsor->id; ?></p></td>
                    <td width="24%"><strong>Package Amount:</strong></td>
                    <td width="30%"><?= $cd->kit->MRP; ?></td>
                </tr>
                <tr>
                    <td><p><strong>Parent ID:</strong><strong> </strong></p></td>
                    <td width="29%"><p><?= $cd->sponsor->id; ?></p></td>
                    <td width="24%"><strong>Package:</strong></td>
                    <td width="30%"><script language="javascript" type="text/javascript">
                        document.write (getAmountInWords("<?php echo sprintf("%01.2f", round($cd->kit->MRP, 0)); ?>"));
                        </script></td>
                </tr>
                <tr>
                    <td><p><strong>Placement:</strong><strong> </strong></p></td>
                    <td width="29%"><p><?= substr($cd->Path, strlen($cd->Path) - 1); ?></p></td>
                    <td width="24%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                </tr>

            </table></td>
    </tr>
    <tr>
        <td><p align="center"><strong>CONFIRMATION OF PAN (Permanent Account Number)</strong><br>
                Please note that all associates have to confirm the below and    sign this document.<br>
                Your commissions will not be paid if we do not receive the below document. </p>
            <div align="center">
                <hr size="2" width="100%" align="center">
            </div>
            <p align="left">&nbsp;&nbsp;&nbsp; 1.My PAN No. is <?= $cd->PanNo ? $cd->PanNo : "-"; ?>&nbsp;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;2.I have not applied for PAN No. </p></td>
    </tr>
    <tr>
        <td><p><strong>I Agree</strong></p>
            <ol>
                <li>Family Future Business marketing Pvt. Ltd. Is a Private Limited Company incorporated under the provisions of the    companies Act, 1956. </li>
                <li>The Company has launched a scheme to promote and market the products of native hood Marketing Pvt. Ltd.</li>
                <li>The person Authorized by the company will explain the business of the company. </li>
                <li>All the Associates should understand the business of the company before joining the scheme filling up and signing of    application form.</li>
                <li>All the payments for purchasing of products of the company, as new associate shall be made by Demand Draft in favour of    Family Future Business Marketing Pvt. Ltd. Only &amp; the cash payment shall    be made at the office of the company. No cheque will be accepted.</li>
                <li>The associate shall deposit all the collection made on behalf of the Family Future Business Marketing Pvt. Ltd.    for the sale of the products of the company form the new associate only at    the office of the Family Future Business Marketing Pvt. Ltd. Or at the    authorized distribution center of the company (as per list published from    time to time). The company shall not be responsible/liable for any liability    for the payment/remittances made /deposited other than the office of the    Family Future Business Marketing Pvt. Ltd. Or at the authorized distribution    center of the company. </li>
                <li>The company reserve the right to make any changes, amendments or alteration in design, nature of content, description,    range, scheme and formulation for the product and services provided by the    company, including any changes in the marketing strategy, compensation plan,    policies and procedure form time to time as the company may deed fit and    necessary to do so. </li>
                <li>The management is having sole discretion to organize the training session/presentation/seminar / Education Programs and    the same will be informed by mail to the Associates accordingly. </li>
                <li>If any associate or staff wants to promote/Market products of the company in any other means except this promotional    plan, which hold the company, to increase its sales, then a prior written    permission is required from the management of the company.</li>
                <li>The payment is not refundable under any circumstances of the purchase of product of Family Future Business Marketing    Pvt. Ltd. </li>
                <li>The Company at its discretion reserves the right to terminate to any Associate. </li>
                <li>Company is not liable for any claim, cost damage due to the misrepresentation of Associate about the quality,    performance or availability of the company&rsquo;s products and services. </li>
                <li>All the above terms and conditions are applicable for everybody including nominee.</li>
                <li>No Associate is allowed to use company&rsquo;s network for marketing / Promoting any other product or scheme which is not    related to company. </li>
                <li>No printed material by associate is allowed to be circulated without the written approval of company.</li>
            </ol>
            <p><br>
                <strong>Name:</strong><strong><?= $distributor->Name ?> </strong><br>
                <br>
                <br>
                <strong>Signature</strong> </p></td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="766">
    <tr>
        <td><span align="center">
                <p>Copyright    &copy; 2011 Family Future Business Marketing Pvt. Ltd. </p></td>
    </tr>
</table>


<?php
if (JRequest::getVar('format') != "raw")
    echo "<a href='index.php?option=com_mlm&task=distributor_cont.futureReceipt&layout=futureReceipt&format=raw' target='_Receipt'>Print</a>";
?>
