<?php
$this->setPageTitle(
    Yii::t('D2fixrModule.model', 'Fixr Fiit Xrefs')
    . ' - '
    . Yii::t('D2fixrModule.crud', 'Manage')
);

//$this->breadcrumbs[] = Yii::t('D2fixrModule.model', 'Fixr Fiit Xrefs');

?>

<?php //$this->widget("TbBreadcrumbs", array("links" => $this->breadcrumbs)) ?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
        <?php 
        $this->widget('bootstrap.widgets.TbButton', array(
             'label'=>Yii::t('D2fixrModule.crud','Create'),
             'icon'=>'icon-plus',
             'size'=>'large',
             'type'=>'success',
             'url'=>array('create'),
             'visible'=>(Yii::app()->user->checkAccess('D2finv.FixrFiitXRef.*') || Yii::app()->user->checkAccess('D2finv.FixrFiitXRef.Create'))
        ));  
        ?>
</div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('D2fixrModule.model', 'Fixr Fiit Xrefs');?>            </h1>
        </div>
    </div>
</div>

<?php Yii::beginProfile('FixrFiitXRef.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'fixr-fiit-xref-grid',
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
                'urlExpression' => 'Yii::app()->controller->createUrl("view", array("fixr_id" => $data["fixr_id"]))'
            ),
            array(
                //int(10) unsigned
                'class' => 'editable.EditableColumn',
                'name' => 'fixr_id',
                'editable' => array(
                    'url' => $this->createUrl('/d2fixr/fixrFiitXRef/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'fixr_fiit_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('/d2fixr/fixrFiitXRef/editableSaver'),
                    'source' => CHtml::listData(FiitInvoiceItem::model()->findAll(array('limit' => 1000)), 'fiit_id', 'itemLabel'),                        
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'fixr_position_fret_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('/d2fixr/fixrFiitXRef/editableSaver'),
                    'source' => CHtml::listData(FretRefType::model()->findAll(array('limit' => 1000)), 'fret_id', 'itemLabel'),                        
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'fixr_period_fret_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('/d2fixr/fixrFiitXRef/editableSaver'),
                    'source' => CHtml::listData(FrepRefPeriod::model()->findAll(array('limit' => 1000)), 'frep_id', 'itemLabel'),                        
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'fixr_fcrn_date',
                'editable' => array(
                    'type' => 'date',
                    'url' => $this->createUrl('/d2fixr/fixrFiitXRef/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'fixr_fcrn_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('/d2fixr/fixrFiitXRef/editableSaver'),
                    'source' => CHtml::listData(FcrnCurrency::model()->findAll(array('limit' => 1000)), 'fcrn_id', 'itemLabel'),                        
                    //'placement' => 'right',
                )
            ),
            array(
                //decimal(10,2)
                'class' => 'editable.EditableColumn',
                'name' => 'fixr_amt',
                'editable' => array(
                    'url' => $this->createUrl('/d2fixr/fixrFiitXRef/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'fixr_base_fcrn_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('/d2fixr/fixrFiitXRef/editableSaver'),
                    'source' => CHtml::listData(FcrnCurrency::model()->findAll(array('limit' => 1000)), 'fcrn_id', 'itemLabel'),                        
                    //'placement' => 'right',
                )
            ),
            /*
            array(
                //decimal(10,2) unsigned
                'class' => 'editable.EditableColumn',
                'name' => 'fixr_base_amt',
                'editable' => array(
                    'url' => $this->createUrl('/d2fixr/fixrFiitXRef/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            */

            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'Yii::app()->user->checkAccess("D2finv.FixrFiitXRef.View")'),
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("D2finv.FixrFiitXRef.Delete")'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("fixr_id" => $data->fixr_id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("fixr_id" => $data->fixr_id))',
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);
?>
<?php Yii::endProfile('FixrFiitXRef.view.grid'); ?>