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
        echo $form->hiddenField($model, 'fpeo_id');
    }
    echo $form->hiddenField($model, 'fpeo_fixr_id');

    echo $form->errorSummary($model);
    ?>
    <?php ?>
    <div class="control-group">
        <div class='control-label'>
            <?php ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fpeo_id')) != 'tooltip.fpeo_id') ? $t : '' ?>'>
                      <?php
                      ;
                      echo $form->error($model, 'fpeo_id')
                      ?>                            </span>
        </div>
    </div>
    <?php ?>

    <?php ?>
    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'fpeo_start_abs_odo') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fpeo_start_abs_odo')) != 'tooltip.fpeo_start_abs_odo') ? $t : '' ?>'>
                      <?php
                      echo $form->textField($model, 'fpeo_start_abs_odo', array('size' => 10, 'maxlength' => 10));
                      echo $form->error($model, 'fpeo_start_abs_odo')
                      ?>                            </span>
        </div>
    </div>
    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'fpeo_end_abs_odo') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fpeo_end_abs_odo')) != 'tooltip.fpeo_end_abs_odo') ? $t : '' ?>'>
                      <?php
                      echo $form->textField($model, 'fpeo_end_abs_odo', array('size' => 10, 'maxlength' => 10));
                      echo $form->error($model, 'fpeo_end_abs_odo')
                      ?>                            </span>
        </div>
    </div>
    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'fpeo_distance') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fpeo_distance')) != 'tooltip.fpeo_distance') ? $t : '' ?>'>
                      <?php
                      echo $form->textField($model, 'fpeo_distance', array('size' => 10, 'maxlength' => 10));
                      echo $form->error($model, 'fpeo_distance')
                      ?>                            </span>
        </div>
    </div>
    <?php $this->endWidget(); ?>   
</div>