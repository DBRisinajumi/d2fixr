<?php
$this->setPageTitle(Yii::t('D2fixrModule.model', 'DIM 1 List'));

$breadcrumbs = array(
        Yii::t('D2fixrModule.model', 'Home'),
    );
$this->widget("TbD2Breadcrumbs", array("links" => $breadcrumbs));
        
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
             'url'=>array('create'),
             'visible'=>(Yii::app()->user->checkAccess('D2fixr.Fdm1Dimension1.*') || Yii::app()->user->checkAccess('D2fixr.Fdm1Dimension1.Create'))
        ));  
        ?>
</div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('D2fixrModule.model', 'DIM 1 List');?>            </h1>
        </div>
    </div>
</div>

<?php Yii::beginProfile('Fdm1Dimension1.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'fdm1-dimension1-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        #'responsiveTable' => true,
        'template' => '{summary}{pager}{items}{pager}',
        'pager' => array(
            'class' => 'TbPager',
            'displayFirstAndLast' => true,
        ),
        'columns' => array(
//            array(
//                //varchar(10)
//                'class' => 'editable.EditableColumn',
//                'name' => 'fdm1_code',
//                'editable' => array(
//                    'url' => $this->createUrl('/d2fixr/fdm1Dimension1/editableSaver'),
//                    'placement' => 'right',
//                )
//            ),
            array(
                //varchar(50)
                'class' => 'editable.EditableColumn',
                'name' => 'fdm1_name',
                'editable' => array(
                    'url' => $this->createUrl('/d2fixr/fdm1Dimension1/editableSaver'),
                    'placement' => 'right',
                )
            ),
            array(
                //tinyint(4)
                'class' => 'editable.EditableColumn',
                'name' => 'fdm1_hidden',
                'editable' => array(
                    'url' => $this->createUrl('/d2fixr/fdm1Dimension1/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //tinyint(4)
                'header' => 'DIM 2',
                'type' => 'raw',
                'value' => 'CHtml::link("OPEN", array("fdm2Dimension2/admin","fdm1_id" => $data->fdm1_id))',
            ),

            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'FALSE'),
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("D2fixr.Fdm1Dimension1.Delete")'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("fdm1_id" => $data->fdm1_id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("fdm1_id" => $data->fdm1_id))',
                'deleteConfirmation'=>Yii::t('D2fixrModule.crud','Do you want to delete this item?'),                    
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);
?>
<?php Yii::endProfile('Fdm1Dimension1.view.grid'); ?>