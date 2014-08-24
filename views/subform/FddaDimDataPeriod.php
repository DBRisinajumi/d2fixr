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
        echo $form->hiddenField($model, 'fdda_id');
    }
    echo $form->hiddenField($model, 'fdda_fixr_id');

    echo $form->errorSummary($model);
    ?>
    <div class="control-group">
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fdda_id')) != 'tooltip.fdda_id') ? $t : '' ?>'>
                      <?php
                      ;
                      echo $form->error($model, 'fdda_id')
                      ?>                            </span>
        </div>
    </div>

    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'fdda_date_from') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fdda_date_from')) != 'tooltip.fdda_date_from') ? $t : '' ?>'>
                      <?php
                      $this->widget('TbDatePicker', array(
                          'model' => $model,
                          'attribute' => 'fdda_date_from',
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
                      echo $form->error($model, 'fdda_date_from')
                      ?>                            </span>
        </div>
    </div>

    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'fdda_date_to') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fdda_date_to')) != 'tooltip.fdda_date_to') ? $t : '' ?>'>
                      <?php
                      $this->widget('TbDatePicker', array(
                          'model' => $model,
                          'attribute' => 'fdda_date_to',
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
                      echo $form->error($model, 'fdda_date_to')
                      ?>                            </span>
        </div>
    </div>

<?php $this->endWidget(); ?>                
</div>