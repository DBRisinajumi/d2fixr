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
            <?php echo $form->labelEx($model, 'vfuf_qnt') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vfuf_qnt')) != 'tooltip.vfuf_qnt') ? $t : '' ?>'>
                      <?php
                      echo $form->textField($model, 'vfuf_qnt', array('size' => 10, 'maxlength' => 10));
                      echo $form->error($model, 'vfuf_qnt')
                      ?>                            </span>
        </div>
    </div>

    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'vfuf_date') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vfuf_date')) != 'tooltip.vfuf_date') ? $t : '' ?>'>
                      <?php
//                      $this->widget('zii.widgets.jui.CJuiDatePicker', array(
//                          'model' => $model,
//                          'attribute' => 'vfuf_date',
//                          'language' => strstr(Yii::app()->language . '_', '_', true),
//                          'htmlOptions' => array('size' => 10),
//                          'options' => array(
//                              'showButtonPanel' => true,
//                              'changeYear' => true,
//                              'changeYear' => true,
//                              'dateFormat' => 'yy-mm-dd',
//                          ),
//                              )
//                      );
                      $this->widget('TbDatePicker', array(
                          'model' => $model,
                          'attribute' => 'vfuf_date',
                          'htmlOptions' => array(
                              'size' => 10,
                              'class' => 'input-small'
                          ),
                          'options' => array(
                              'autoclose' => true,
                              'todayHighlight' => true,
                              'showButtonPanel' => true,
                              'changeYear' => true,
                              'format' => 'yyyy-mm-dd',
                          ),
                              )
                      );                     
                      echo $form->error($model, 'vfuf_date')
                      ?>                            </span>
        </div>
    </div>     

    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'vfuf_notes') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vfuf_notes')) != 'tooltip.vfuf_notes') ? $t : '' ?>'>
                      <?php
                      echo $form->textArea($model, 'vfuf_notes', array('rows' => 6, 'cols' => 50));
                      echo $form->error($model, 'vfuf_notes')
                      ?>                            </span>
        </div>
    </div>

    <?php $this->endWidget(); ?>   
</div>