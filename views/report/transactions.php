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
        <td><?=$row['finv_number']?></td>
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


