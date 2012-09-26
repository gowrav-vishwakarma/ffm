<?php
    $c=new xConfig('rewards');
//    $r=array($c->getkey('Reward1_PairPoint')*1000,$c->getkey('Reward2_PairPoint')*1000,$c->getkey('Reward3_PairPoint')*1000,$c->getkey('Reward4_PairPoint')*1000,$c->getkey('Reward5_PairPoint')*1000,$c->getkey('Reward6_PairPoint')*1000);
      $r=array($c->getkey('Reward1_PairPoint')*1000,$c->getkey('Reward2_PairPoint')*1000,$c->getkey('Reward3_PairPoint')*1000,$c->getkey('Reward4_PairPoint')*1000,$c->getkey('Reward5_PairPoint')*1000,$c->getkey('Reward7_PairPoint')*1000,$c->getkey('Reward8_PairPoint')*1000,$c->getkey('Reward9_PairPoint')*1000);
?>
<html>
    <head>

    </head>
    <body>
        <table width="100%">
            <tr>
                <td>Pairs</td>                
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
                    $reward_i = "Reward$i";
                    echo "<tr><td>". $award/1000 ."</td>";
                    if($special->{$reward_i}=="0000-00-00 00:00:00"){
                        echo"<td></td><td>Running</td></tr>";
                    }
                    else if($special->{$reward_i}=="1970-01-01 00:00:00"){
                        echo"<td></td><td>Collapsed</td></tr>";
                    }
                    else{
                        echo"<td>".$special->{$reward_i}."</td><td>Achieved</td></tr>";
                    }
                    $i++;
                }
            ?>
        </table>
    </body>
</html>