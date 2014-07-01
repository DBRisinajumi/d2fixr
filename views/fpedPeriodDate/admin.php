<?php
$this->setPageTitle(
    Yii::t('D2finvModule.model', 'Fped Period Dates')
    . ' - '
    . Yii::t('D2finvModule.crud', 'Manage')
);

//$this->breadcrumbs[] = Yii::t('D2finvModule.model', 'Fped Period Dates');

?>

<?php //$this->widget("TbBreadcrumbs", array("links" => $this->breadcrumbs)) ?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
        <?php 
        $this->widget('bootstrap.widgets.TbButton', array(
             'label'=>Yii::t('D2finvModule.crud','Create'),
             'icon'=>'icon-plus',
             'size'=>'large',
             'type'=>'success',
             'url'=>array('create'),
             'visible'=>(Yii::app()->user->checkAccess('D2finv.FpedPeriodDate.*') || Yii::app()->user->checkAccess('D2finv.FpedPeriodDate.Create'))
        ));  
        ?>
</div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('D2finvModule.model', 'Fped Period Dates');?>            </h1>
        </div>
    </div>
</div>

<?php Yii::beginProfile('FpedPeriodDate.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'fped-period-date-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        #'responsiveTable' => true,
        'template' => '{summary}{pager}{items}{pager}',
        'pager' => array(
            'class' => 'TbPager',
            'displayFirstAndLast' => true,
        ),
        'columns' => array(
            array(
                'class' => 'CLinkColumn',
                'header' => '',
                'labelExpression' => '$data->itemLabel',
                'urlExpression' => 'Yii::app()->controller->createUrl("view", array("fped_id" => $data["fped_id"]))'
            ),
            array(
                //int(10) unsigned
                'class' => 'editable.EditableColumn',
                'name' => 'fped_id',
                'editable' => array(
                    'url' => $this->createUrl('/d2finv/fpedPeriodDate/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'fped_fixr_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('/d2finv/fpedPeriodDate/editableSaver'),
                    'source' => CHtml::listData(FixrFiitXRef::model()->findAll(array('limit' => 1000)), 'fixr_id', 'itemLabel'),                        
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'fped_start_date',
                'editable' => array(
                    'type' => 'date',
                    'url' => $this->createUrl('/d2finv/fpedPeriodDate/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'fped_end_date',
                'editable' => array(
                    'type' => 'date',
                    'url' => $this->createUrl('/d2finv/fpedPeriodDate/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'fped_month',
                'editable' => array(
                    'type' => 'date',
                    'url' => $this->createUrl('/d2finv/fpedPeriodDate/editableSaver'),
                    //'placement' => 'right',
                )
            ),

            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'Yii::app()->user->checkAccess("D2finv.FpedPeriodDate.View")'),
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("D2finv.FpedPeriodDate.Delete")'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("fped_id" => $data->fped_id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("fped_id" => $data->fped_id))',
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);
?>
<?php Yii::endProfile('FpedPeriodDate.view.grid'); ?>