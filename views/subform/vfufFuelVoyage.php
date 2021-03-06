<div class="crud-form">
    <?php
    $form = $this->beginWidget('TbActiveForm', array(
        'id' => 'expense_data_form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array(
            'enctype' => ''
        )
    ));

    echo CHtml::hiddenField('fret_id', $fret_id);
    echo CHtml::hiddenField('fixr_id', $fixr_id);


    if (!$model->getIsNewRecord()) {
        echo $form->hiddenField($model, 'vfuf_id');
    }
    echo $form->hiddenField($model, 'vfuf_fixr_id');

    echo $form->errorSummary($model);
    ?>

    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'vfuf_vvoy_id') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vfuf_vvoy_id')) != 'tooltip.vfuf_vvoy_id') ? $t : '' ?>'>
                      <?php
                      $this->widget(
                              '\GtcRelation', array(
                          'model' => $model,
                          'relation' => 'vfufVvoy',
                          'fields' => 'itemLabel',
                          'allowEmpty' => true,
                          'style' => 'dropdownlist',
                          'htmlOptions' => array(
                              'checkAll' => 'all'
                          ),
                              )
                      );
                      echo $form->error($model, 'vfuf_vvoy_id')
                      ?>                            </span>
        </div>
    </div>

    <?php $this->endWidget(); ?>   
</div>