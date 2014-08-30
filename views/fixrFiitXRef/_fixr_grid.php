<?php

$this->widget('TbGridView', array(
    'id' => $sub_grid_id,
    'dataProvider' => $model->search(),
    'template' => '{summary}{items}',
    'summaryText' => '&nbsp;',
    'htmlOptions' => array(
        'class' => 'rel-grid-view-sub'
    ),
    'columns' => array(
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
            'header' => Yii::t('D2fixrModule.model', 'Position'),
            'type' => 'raw',
            'value' => 'CHtml::link($data->getPositionLabel(),
                                                array(\'/d2fixr/fixrFiitXRef/popupPosition\',\'fixr_id\' =>$data->fixr_id)
                                            );'
        ),
        array(
            'header' => Yii::t('D2fixrModule.model', 'Period'),
            'type' => 'raw',
            'value' => '(!$data->isPeriodEditable())?
                            $data->getPeriodLabel(false)
                            :CHtml::link(
                                $data->getPeriodLabel(),
                                array(
                                    \'/d2fixr/fixrFiitXRef/popupPeriod\',
                                    \'fixr_id\' =>$data->fixr_id,
                                    )
                            );'
        ),
        array(
            'class' => 'TbButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'FALSE'),
                'update' => array('visible' => 'FALSE'),
                'delete' => array('visible' => 'Yii::app()->user->checkAccess("D2finv.FretRefType.DeletefixrFiitXRefs")'),
            ),
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/d2fixr/fixrFiitXRef/delete", array("fixr_id" => $data->fixr_id))',
            'deleteButtonOptions' => array('data-toggle' => 'tooltip'),
        ),
    ),))
;
