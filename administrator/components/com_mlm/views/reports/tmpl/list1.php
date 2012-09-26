<html>
    <head></head>
    <body>
        <?php 
            $sdate=strtotime($sdate);
            $edate=strtotime($edate);
            $tableNo;
        ?>
        <table align="center" width="100%" border="1">
            <tr>
                <th>Name</th>
                <th>Joining Date</th>
                <?php
                if($tableNo==1)
                {
                   $Norewards=6;
                }
                
                elseif($tableNo==2)
                {
                     $Norewards=4;
                }
                else
                {
                     $Norewards=10;
                }
                
                for($i=1;$i<=$Norewards;$i++)
                {
                   echo "<th>Reward$i</th>";
                }
                ?>
                
            </tr>
            <?php foreach($results as $d):
                echo "<tr><td>$d->name</td><td>$d->jd</td>";
            ?>
                <?php for($i=1;$i<=$Norewards;$i++){                 
                        $reward="r".$i;
                        echo "<td>";
                    if( $sdate<=strtotime($d->{$reward}) && $edate>=strtotime($d->{$reward}))
                    {
                        echo $d->{$reward};
                    }
                    else
                        echo "---";
                    echo"</td>";
                }
                ?>
            
            <?php 
                echo "</tr>";
                endforeach;
            ?>
           </table>
    </body>
</html>