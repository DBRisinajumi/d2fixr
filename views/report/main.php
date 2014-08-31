<table>
    <tr>
        <td></td>
        <?php 
        //var_dump($months);
        foreach($months as $m){
            ?><th><? echo $m['label']; ?></th><?
        }
        ?>
    </tr>
    <?php 
        foreach ($positions as $p){
            ?><tr>
                <th><? echo $p['name']; ?></th>
                <?php
//                var_dump($p['fdm1_id']);
                        foreach ($table[$p['fdm1_id']] as $t) {
                            ?><td><? echo $t; ?></td><?
                        }
            ?></tr><?php
    
    }
    ?>
</table>
<?php

//            'months' => $months,
//            'positions' => $positions,
//            'table' => $table,

