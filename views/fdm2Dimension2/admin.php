<?php
$this->setPageTitle(
    Yii::t('D2fixrModule.model', 'DIM 2 List')
    . ' - '
    . $fdm1->fdm1_name
);

$breadcrumbs = array(
        Yii::t('D2fixrModule.model', 'Home') => array('fdm1Dimension1/admin'),
        $fdm1->fdm1_name,
    );
$this->widget("TbD2Breadcrumbs", array("links" => $breadcrumbs))
?>


<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
        <?php 
        $this->widget('bootstrap.widgets.TbButton', array(
             'label'=>Yii::t('D2fixrModule.crud','Create'),
             'icon'=>'icon-plus',
             'size'=>'large',
             'type'=>'success',
             'url'=>array('create','fdm1_id' => $fdm1->fdm1_id),
             'visible'=>(Yii::app()->user->checkAccess('D2fixr.Fdm2Dimension2.*') || Yii::app()->user->checkAccess('D2fixr.Fdm2Dimension2.Create'))
        ));  
        ?>
</div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('D2fixrModule.model', $fdm1->fdm1_name);?>            </h1>
        </div>
    </div>
</div>

<?php 

Yii::beginProfile('Fdm2Dimension2.view.grid');

$find_all_param = array(
    'order'=>'fret_label',
    'condition'=>"fret_controller_action = 'FixrFiitXRef/popupPosition'",
    );                                
$fret_data = FretRefType::model()->findAll($find_all_param);

$this->widget('TbGridView',
    array(
        'id' => 'fdm2-dimension2-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        #'responsiveTable' => true,
        'template' => '{items}{pager}',
        'pager' => array(
            'class' => 'TbPager',
            'displayFirstAndLast' => true,
        ),
        'columns' => array(
            array(
                //varchar(10)
                'class' => 'editable.EditableColumn',
                'name' => 'fdm2_code',
                'editable' => array(
                    'url' => $this->createUrl('/d2fixr/fdm2Dimension2/editableSaver'),
                    'placement' => 'right',
                )
            ),
            array(
                //varchar(50)
                'class' => 'editable.EditableColumn',
                'name' => 'fdm2_name',
                'editable' => array(
                    'url' => $this->createUrl('/d2fixr/fdm2Dimension2/editableSaver'),
                    //'placement' => 'right',
                )
            ),            
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'fdm2_fret_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('/d2fixr/fdm2Dimension2/editableSaver'),
                    'source' => CHtml::listData($fret_data, 'fret_id', 'itemLabel'),
                    //'placement' => 'right',
                )
            ),
            array(
                'name' => 'fdm2_ref_id',
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'fdm2_hidden',
                'editable' => array(
                    'url' => $this->createUrl('/d2fixr/fdm2Dimension2/editableSaver'),
                    //'placement' => 'right',
                ),
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),
            ),
            array(
                //tinyint(4)
                'header' => 'DIM 3',
                'type' => 'raw',
                'value' => 'CHtml::link("OPEN", array("fdm3Dimension3/admin","fdm2_id" => $data->fdm2_id))',
            ),
            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'FALSE'),
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("D2fixr.Fdm2Dimension2.Delete")'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("fdm2_id" => $data->fdm2_id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("fdm2_id" => $data->fdm2_id))',
                'deleteConfirmation'=>Yii::t('D2fixrModule.crud','Do you want to delete this item?'),                    
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);
?>
<?php Yii::endProfile('Fdm2Dimension2.view.grid'); ?>