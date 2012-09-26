<?php
//    $c=new xConfig('rewards');
//    $r=array($c->getkey('Reward1_PairPoint')*1000,$c->getkey('Reward2_PairPoint')*1000,$c->getkey('Reward3_PairPoint')*1000,$c->getkey('Reward4_PairPoint')*1000,$c->getkey('Reward5_PairPoint')*1000,$c->getkey('Reward6_PairPoint')*1000);
    $r=array("10"=>"10",
            "40"=>"30",
            "100"=>"45",
            "180"=>"100000",
            "280"=>"60",
            "455"=>"180",
            "705"=>"365",
            "1205"=>"730",
            "2705"=>"100000",
            "7705"=>"100000");
?>
<html>
    <head>

    </head>
    <body>
        <table width="100%">
            <tr>
                <td>Pairs</td>
                <td>Date To Complete</td>
                <td>Reward Date</td>
                <td>Status</td>
            </tr>
            <?php
                $i=1;
                //echo ($join), "\n";
                $d=explode("-",$join);
                //print_r($d);//$string)
                $date=mktime(0,0,0,$d[1],$d[2],$d[0]);
                //echo date("Y-m-d",$date);
                foreach($r as $pair=>$award){                    
                    $reward_i = "reward$i";
                    if($award!=100000)
                        echo "<tr><td>$pair</td><td>".date("Y-m-d",strtotime("+".$award." days",$date))."</td>";
                    else
                        echo "<tr><td>$pair</td><td>No Limit</td>";
                    if($bv->{$reward_i}=="0000-00-00 00:00:00"){
                        echo"<td></td><td>Running</td></tr>";
                    }
                    else if($bv->{$reward_i}=="1970-01-01 00:00:00"){
                        echo"<td></td><td>Collapsed</td></tr>";
                    }
                    else{
                        echo"<td>".$bv->{$reward_i}."</td><td>Achieved</td></tr>";
                    }
                    $i++;
                }
            ?>
        </table>
    </body>
</html>
<?php
//strtotime(date("Y-m-d",strtotime($join))," +".$award." day")
//echo date("Y-m-d",strtotime(date("Y-m-d", strtotime($join)) . " +".$i." day"));
?>