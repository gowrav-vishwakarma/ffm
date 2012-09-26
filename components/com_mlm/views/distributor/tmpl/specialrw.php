<?php
//    $c=new xConfig('rewards');
//    $r=array($c->getkey('Reward1_PairPoint')*1000,$c->getkey('Reward2_PairPoint')*1000,$c->getkey('Reward3_PairPoint')*1000,$c->getkey('Reward4_PairPoint')*1000,$c->getkey('Reward5_PairPoint')*1000,$c->getkey('Reward6_PairPoint')*1000);
    $r=array(
            /*
            'pairs' => 'days'
             */
            "30"=>"10000",
            "60"=>"35000",
            "90"=>"85000",
            "180"=>"335000");
?>
<html>
    <head>

    </head>
    <body>
        <table width="100%">
            <tr>
                <td>Pairs (PV)</td>
                <td>Date To Complete</td>
                <td>Reward Date</td>
                <td>Status</td>
            </tr>
            <?php
                $i=1;
                foreach($r as $pair=>$award){
                    $reward_i = "reward$i";
                    echo "<tr><td>$award</td><td>".date("Y-m-d",strtotime(date("Y-m-d", strtotime($join)) . " +".$pair." day"))."</td>";
                    if($pv->{$reward_i}=="0000-00-00 00:00:00"){
                        echo"<td></td><td>Running</td></tr>";
                    }
                    else if($pv->{$reward_i}=="1970-01-01 00:00:00"){
                        echo"<td></td><td>Collapsed</td></tr>";
                    }
                    else{
                        echo"<td>".$pv->{$reward_i}."</td><td>Achieved</td></tr>";
                    }
                    $i++;
                }
            ?>
        </table>
    </body>
</html>