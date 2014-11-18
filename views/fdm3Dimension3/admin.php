<?php
$this->setPageTitle(
    Yii::t('D2fixrModule.model', 'Fdm3 Dimension3s')
    . ' - '
    . Yii::t('D2fixrModule.crud', 'Manage')
);

$breadcrumbs[] = Yii::t('D2fixrModule.model', 'Fdm3 Dimension3s');

$breadcrumbs = array(
        Yii::t('D2fixrModule.model', 'Home') => array('fdm1Dimension1/admin'),
        $fdm2->fdm2Fdm1->fdm1_name => array(
            'fdm2Dimension2/admin','fdm1_id' => $fdm2->fdm2_fdm1_id,
            ),
        $fdm2->fdm2_name,
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
             'url'=>array('create','fdm2_id' => $fdm2->fdm2_id),
             'visible'=>(Yii::app()->user->checkAccess('D2fixr.Fdm3Dimension3.*') || Yii::app()->user->checkAccess('D2fixr.Fdm3Dimension3.Create'))
        ));  
        ?>
</div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo $fdm2->fdm2Fdm1->fdm1_name . ' - ' . $fdm2->fdm2_name;?>            </h1>
        </div>
    </div>
</div>

<?php Yii::beginProfile('Fdm3Dimension3.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'fdm3-dimension3-grid',
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
                'name' => 'fdm3_fret_id',
                'value' => '$data->fdm3Fret->itemLabel',

            ),
            array(
                'name' => 'fdm3_ref_id',
            ),
            array(
                'name' => 'fdm3_fdm1_id',
                'value' => '$data->fdm3Fdm1->fdm1_name',                
            ),
            array(
                'name' => 'fdm3_fdm2_id',
                'value' => '$data->fdm3Fdm2->fdm2_name',                
            ),
//            array(
//                //varchar(10)
//                'class' => 'editable.EditableColumn',
//                'name' => 'fdm3_code',
//                'editable' => array(
//                    'url' => $this->createUrl('/d2fixr/fdm3Dimension3/editableSaver'),
//                    //'placement' => 'right',
//                )
//            ),
            array(
                //varchar(50)
                'class' => 'editable.EditableColumn',
                'name' => 'fdm3_name',
                'editable' => array(
                    'url' => $this->createUrl('/d2fixr/fdm3Dimension3/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            /*
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'fdm3_hidden',
                'editable' => array(
                    'url' => $this->createUrl('/d2fixr/fdm3Dimension3/editableSaver'),
                    //'placement' => 'right',
                ),
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),
            ),
            */

            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'FALSE'),
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'TRUE'),
                ),
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("fdm3_id" => $data->fdm3_id))',
                'deleteConfirmation'=>Yii::t('D2fixrModule.crud','Do you want to delete this item?'),                    
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);
?>
<?php Yii::endProfile('Fdm3Dimension3.view.grid'); ?>