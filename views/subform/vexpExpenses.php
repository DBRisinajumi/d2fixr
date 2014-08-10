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
        echo $form->hiddenField($model, 'vexp_id');
    }
    echo $form->hiddenField($model, 'vexp_fixr_id');

    echo $form->errorSummary($model);
    ?>
    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'vexp_vepo_id') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vexp_vepo_id')) != 'tooltip.vexp_vepo_id') ? $t : '' ?>'>
                      <?php
                      $this->widget(
                              '\GtcRelation', array(
                          'model' => $model,
                          'relation' => 'vexpVepo',
                          'fields' => 'itemLabel',
                          'allowEmpty' => true,
                          'style' => 'dropdownlist',
                          'htmlOptions' => array(
                              'checkAll' => 'all'
                          ),
                              )
                      );
                      echo $form->error($model, 'vexp_vepo_id')
                      ?>                            </span>
        </div>
    </div>
    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'vexp_notes') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('VvoyModule.model', 'tooltip.vexp_notes')) != 'tooltip.vexp_notes') ? $t : '' ?>'>
                      <?php
                      echo $form->textArea($model, 'vexp_notes', array('rows' => 6, 'cols' => 50));
                      echo $form->error($model, 'vexp_notes')
                      ?>                            </span>
        </div>
    </div>
    <?php $this->endWidget(); ?>   
</div>