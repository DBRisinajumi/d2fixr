<div class="table-header">
<?=$label?> <?=$year?>-<?=str_pad($month,2,'0',STR_PAD_LEFT)?>
    
</div>
<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th><?= Yii::t('D2fixrModule.model', 'Invoice number') ?></th>
        <th><?= Yii::t('D2fixrModule.model', 'Invoice date') ?></th>
        <th><?= Yii::t('D2fixrModule.model', 'Descriptions') ?></th>
        <th><?= Yii::t('D2fixrModule.model', 'Period Amount') ?></th>
        <th><?= Yii::t('D2fixrModule.model', 'Full Amount') ?></th>
    </tr>    
    </thead>
    <tbody>
    <?php 
    $total = 0;
    foreach($data as $row){
        $total +=  $row['fddp_amt']/100;
        ?>
    <tr>
        <td>
            <?php 
            $url = array('/d2finv/finvInvoice/view','finv_id'=>$row['finv_id']);
            $htmlOptions = array(
                    'title' => Yii::t('D2fixrModule.model', 'Details'),
                    'data-toggle' => 'tooltip',
                    'target' => '_blank',
            );
            echo $row['finv_number'] 
                    . ' '
                    . CHtml::link(Yii::t('D2fixrModule.model', 'Invoice') . ' <i class="icon-external-link"></i>',$url,$htmlOptions); 

            $url = array('/d2fixr/FixrFiitXRef/viewFinv','finv_id'=>$row['finv_id']);
            $htmlOptions = array(
                    'title' => Yii::t('D2fixrModule.model', 'Invoice expenses postions'),
                    'data-toggle' => 'tooltip',
                    'target' => '_blank',                
            );
            echo ' '
                    . CHtml::link(Yii::t('D2fixrModule.model', 'Positions') . ' <i class="icon-external-link"></i>',$url,$htmlOptions); 
            ?>        
        </td>
        <td><?=$row['finv_date']?></td>
        <td><?=$row['fiit_desc']?></td>
        <td class="numeric-column"><?=$row['fddp_amt']/100?></td>
        <td class="numeric-column"><?=$row['fixr_base_amt']?></td>
    </tr>
        <?php
    }
    
    ?>
        <tr>
            <td colspan="3"  class="total-row"><?= Yii::t('D2fixrModule.model', 'Total') ?>:</td>
        <td class="total-row numeric-column"><?=$total?></td>
        <td class="total-row numeric-column"></td>
    </tr>
    </tbody>
</table>


