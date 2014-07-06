<div class="crud-form">
    <?php
    //Yii::app()->bootstrap->registerPackage('select2');
    //Yii::app()->clientScript->registerScript('crud/variant/update','$("#vtdc-truck-doc-form select").select2();');

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
    
   
    if(!$model->getIsNewRecord()){
       echo $form->hiddenField($model,'vtdc_id'); 
    }   
    echo $form->hiddenField($model,'vtdc_fixr_id');
    echo $form->errorSummary($model);
    ?>
    <div class="control-group">
        <div class='control-label'>
            <?php ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtdc_id')) != 'tooltip.vtdc_id') ? $t : '' ?>'>
                      <?php
                      ;
                      echo $form->error($model, 'vtdc_id')
                      ?>                            </span>
        </div>
    </div>

    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'vtdc_vtrc_id') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtdc_vtrc_id')) != 'tooltip.vtdc_vtrc_id') ? $t : '' ?>'>
                      <?php
                      $this->widget(
                              '\GtcRelation', array(
                          'model' => $model,
                          'relation' => 'vtdcVtrc',
                          'fields' => 'itemLabel',
                          'allowEmpty' => true,
                          'style' => 'dropdownlist',
                          'htmlOptions' => array(
                              'checkAll' => 'all'
                          ),
                              )
                      );
                      echo $form->error($model, 'vtdc_vtrc_id')
                      ?>                            </span>
        </div>
    </div>
    <?php ?>


    <?php ?>
    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'vtdc_vtdt_id') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtdc_vtdt_id')) != 'tooltip.vtdc_vtdt_id') ? $t : '' ?>'>
                      <?php
                      $this->widget(
                              '\GtcRelation', array(
                          'model' => $model,
                          'relation' => 'vtdcVtdt',
                          'fields' => 'itemLabel',
                          'allowEmpty' => true,
                          'style' => 'dropdownlist',
                          'htmlOptions' => array(
                              'checkAll' => 'all'
                          ),
                              )
                      );
                      echo $form->error($model, 'vtdc_vtdt_id')
                      ?>                            </span>
        </div>
    </div>
    <?php ?>

    <?php ?>
    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'vtdc_number') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtdc_number')) != 'tooltip.vtdc_number') ? $t : '' ?>'>
                      <?php
                      echo $form->textField($model, 'vtdc_number', array('size' => 50, 'maxlength' => 50));
                      echo $form->error($model, 'vtdc_number')
                      ?>                            </span>
        </div>
    </div>
    <?php ?>

    <?php ?>
    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'vtdc_issue_date') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtdc_issue_date')) != 'tooltip.vtdc_issue_date') ? $t : '' ?>'>
                      <?php
                      $this->widget('TbDatePicker', array(
                            'model' => $model,
                            'attribute' => 'vtdc_issue_date',
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
         
                      echo $form->error($model, 'vtdc_issue_date')
                      ?>                            </span>
        </div>
    </div>
    <?php ?>

    <?php ?>
    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'vtdc_expire_date') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtdc_expire_date')) != 'tooltip.vtdc_expire_date') ? $t : '' ?>'>
                      <?php
                      $this->widget('TbDatePicker', array(
                          'model' => $model,
                          'attribute' => 'vtdc_expire_date',
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
                      echo $form->error($model, 'vtdc_expire_date')
                      ?>                            </span>
        </div>
    </div>
    <?php ?>

    <?php ?>
    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'vtdc_notes') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtdc_notes')) != 'tooltip.vtdc_notes') ? $t : '' ?>'>
                      <?php
                      echo $form->textArea($model, 'vtdc_notes', array('rows' => 6, 'cols' => 50));
                      echo $form->error($model, 'vtdc_notes')
                      ?>                            </span>
        </div>
    </div>
</div> 
<?php
$this->endWidget();