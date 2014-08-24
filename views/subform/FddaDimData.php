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
    <?php ?>
    <div class="control-group">
        <div class='control-label'>
            <?php echo $form->labelEx($model, 'fdda_fdm2_id') ?>
        </div>
        <div class='controls'>
            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                  title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fdda_fdm3_id')) != 'tooltip.fdda_fdm3_id') ? $t : '' ?>'>
                      <?php
                      //get select fret list
                      $criteria = new CDbCriteria;
                      $criteria->compare('fdm2_fret_id', $fret_id);
                      $fdm2_list = Fdm2Dimension2::model()->findAll($criteria);

                      //create array for grouped listbox
                      $list_data = array();
                      foreach ($fdm2_list as $fdm2) {
                          $sublist = array();
                          foreach ($fdm2->fdm3Dimension3s as $fdm3) {
                              $sublist[$fdm3->fdm3_id] = $fdm3->fdm3_name;
                          }
                          $list_data[$fdm2->fdm2_name] = $sublist;
                      }
                      echo $form->dropDownList($model, 'fdda_fdm3_id', $list_data, array('prompt' => Yii::t('D2fixrModule.model', 'Select position')));

                      echo $form->error($model, 'fdda_fdm3_id')
                      ?>                            </span>
        </div>
    </div>
    <?php ?>

    <?php $this->endWidget(); ?>   
</div>