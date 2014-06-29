<div class="crud-form">
    <?php ?>    
    <?php
    Yii::app()->bootstrap->registerPackage('select2');
    Yii::app()->clientScript->registerScript('crud/variant/update', '$("#vtrs-truck-service-form select").select2();');


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
        echo $form->hiddenField($model, 'vtrs_id');
    }
    echo $form->hiddenField($model, 'vtrs_fixr_id');

    echo $form->errorSummary($model);
    ?>

    <div class="control-group">
        <div class='control-label'>

        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtrs_id')) != 'tooltip.vtrs_id') ? $t : '' ?>'>
                      <?php
                      echo $form->error($model, 'vtrs_id')
                      ?>                            </span>
        </div>
    </div>
    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'vtrs_vtrc_id') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtrs_vtrc_id')) != 'tooltip.vtrs_vtrc_id') ? $t : '' ?>'>
                      <?php
                      $this->widget(
                              '\GtcRelation', array(
                          'model' => $model,
                          'relation' => 'vtrsVtrc',
                          'fields' => 'itemLabel',
                          'allowEmpty' => true,
                          'style' => 'dropdownlist',
                          'htmlOptions' => array(
                              'checkAll' => 'all'
                          ),
                              )
                      );
                      echo $form->error($model, 'vtrs_vtrc_id')
                      ?>                            </span>
        </div>
    </div>
    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'vtrs_vsrv_id') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtrs_vsrv_id')) != 'tooltip.vtrs_vsrv_id') ? $t : '' ?>'>
                      <?php
                      $this->widget(
                              '\GtcRelation', array(
                          'model' => $model,
                          'relation' => 'vtrsVsrv',
                          'fields' => 'itemLabel',
                          'allowEmpty' => true,
                          'style' => 'dropdownlist',
                          'htmlOptions' => array(
                              'checkAll' => 'all'
                          ),
                              )
                      );
                      echo $form->error($model, 'vtrs_vsrv_id')
                      ?>                            </span>
        </div>
    </div>
    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'vtrs_notes') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtrs_notes')) != 'tooltip.vtrs_notes') ? $t : '' ?>'>
                      <?php
                      echo $form->textArea($model, 'vtrs_notes', array('rows' => 6, 'cols' => 50));
                      echo $form->error($model, 'vtrs_notes')
                      ?>                            
            </span>
        </div>
    </div>
    <?php ?>

</div>
<?php
$this->endWidget();
