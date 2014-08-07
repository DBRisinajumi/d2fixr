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
        echo $form->hiddenField($model, 'fped_id');
    }
    echo $form->hiddenField($model, 'fped_fixr_id');

    echo $form->errorSummary($model);
    ?>
    <div class="control-group">
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('D2finvModule.model', 'tooltip.fped_id')) != 'tooltip.fped_id') ? $t : '' ?>'>
                      <?php
                      ;
                      echo $form->error($model, 'fped_id')
                      ?>                            </span>
        </div>
    </div>

    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'fped_start_date') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('D2finvModule.model', 'tooltip.fped_start_date')) != 'tooltip.fped_start_date') ? $t : '' ?>'>
                      <?php
                      $this->widget('TbDatePicker', array(
                          'model' => $model,
                          'attribute' => 'fped_start_date',
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
                      echo $form->error($model, 'fped_start_date')
                      ?>                            </span>
        </div>
    </div>

    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'fped_end_date') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('D2finvModule.model', 'tooltip.fped_end_date')) != 'tooltip.fped_end_date') ? $t : '' ?>'>
                      <?php
                      $this->widget('TbDatePicker', array(
                          'model' => $model,
                          'attribute' => 'fped_end_date',
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
                      echo $form->error($model, 'fped_end_date')
                      ?>                            </span>
        </div>
    </div>

<?php $this->endWidget(); ?>                
</div>