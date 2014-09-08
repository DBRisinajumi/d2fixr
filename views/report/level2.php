<?php
$fdm1 = Fdm1Dimension1::model()->findByPk($fdm1_id);

$breadcrumbs[Yii::t('D2fixrModule.model', 'Home')] = array('level1','year'=>$year);
$breadcrumbs[] = $fdm1->itemLabel;
$this->widget("vendor.uldisn.ace.widgets.TbAceBreadcrumbs", array(
    'links' => $breadcrumbs,
    ));
?>

<div class="table-header">
    <?php
    echo Yii::t('D2fixrModule.model', 'Dimensions:'). ' ';
    echo $fdm1->itemLabel. ' / ';
    echo Yii::t('D2fixrModule.model', 'Year:');
    $prev_year = $year - 1;
    $next_year = $year + 1;
    $this->widget(
            'bootstrap.widgets.TbButton', array(
                'buttonType' => 'link',
                'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'size' => 'mini',
                'icon' => 'icon-chevron-left',
                'url' => array(
                    'level2',
                    'year' => $prev_year,
                    'fdm1_id'=>$fdm1_id,
                ),
                'htmlOptions' => array(
                    'title' => $prev_year,
                    'data-toggle' => 'tooltip',
                    'icon_class' => '',
                ),
            )
    );        
    echo $year;    
    $this->widget(
            'bootstrap.widgets.TbButton', array(
                'buttonType' => 'link',
                'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'size' => 'mini',
                'icon' => 'icon-chevron-right',
                //'label' => '2015',
                'url' => array(
                    'level2',
                    'year' => $next_year,
                    'fdm1_id'=>$fdm1_id,
                ),
                'htmlOptions' => array(
                    'title' => $next_year,
                    'data-toggle' => 'tooltip',
                    'icon_class' => '',
                ),
            )
    );        
    
    ?>
</div>

<table class="items table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <td></td>
            <?php 
            foreach($months as $m){
                ?><th><? echo $m['label']; ?></th><?
            }
            ?>
                <th><?php echo yii::t('D2fixrModule.model', 'Total')?></th>    
        </tr>
    </thead>
    <tbody>
    <?php 
        foreach ($positions as $p_key => $p){
            ?><tr>
                <th><? echo CHtml::link($p['name'],array('level3','fdm1_id'=>$fdm1_id,'fdm2_id'=>$p['row_id'],'year'=>$year)); ?></th>
                <?php
                        foreach ($table[$p['row_id']] as $m => $t) {
                            ?><td class="numeric-column"><? echo CHtml::link($t,array('level3transactions','fdm2_id'=>$p['row_id'],'month'=>$m, 'year'=>$year)); ?></td><?
                        }
                ?>
                <td class="numeric-column total-row"><?php echo $rows_totals[$p['row_id']] ?></td>
                <?php        
                 
            ?></tr><?php
    
    }
    ?>
        <tr>
            <td class="total-row"><?php echo yii::t('D2fixrModule.model', 'Total')?></td>
    <?php
    foreach($columns_totals as $amt){
                ?>
                <td class="numeric-column total-row"><?php echo $amt ?></td>
                <?php        
        
    }
    ?>
            <td class="numeric-column total-row"><?php echo $total ?></td>                
        </tr>
    </tbody>
</table>
<?php

//            'months' => $months,
//            'positions' => $positions,
//            'table' => $table,

