
    <div class="widget-box no-padding">
        <div class="widget-header">
            <h4><?= Yii::t('D2fixrModule.model', 'Set period data') ?></h4>
        </div>
        <div class="widget-body">
            <div class="widget-main no-padding">
                <div class="form-horizontal">
                <?php
//        Yii::app()->bootstrap->registerPackage('select2');
//        Yii::app()->clientScript->registerScript('crud/variant/update','$("#fped-period-date-form select").select2();');

                $form = $this->beginWidget('TbActiveForm', array(
                    'id' => 'period_dialog_form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'htmlOptions' => array(
                        'enctype' => ''
                    )
                ));

                echo $form->errorSummary($model);
                ?>



                <fieldset></fieldset>


                    <?php ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                  title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fped_id')) != 'tooltip.fped_id') ? $t : '' ?>'>
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
                                  title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fped_start_date')) != 'tooltip.fped_start_date') ? $t : '' ?>'>
                                      <?php
                                      $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                          'model' => $model,
                                          'attribute' => 'fped_start_date',
                                          'language' => strstr(Yii::app()->language . '_', '_', true),
                                          'htmlOptions' => array('size' => 10),
                                          'options' => array(
                                              'showButtonPanel' => true,
                                              'changeYear' => true,
                                              'changeYear' => true,
                                              'dateFormat' => 'yy-mm-dd',
                                          ),
                                              )
                                      );
                                      ;
                                      echo $form->error($model, 'fped_start_date')
                                      ?>                            </span>
                        </div>
                    </div>
                    <?php ?>

                    <?php ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'fped_end_date') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                  title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fped_end_date')) != 'tooltip.fped_end_date') ? $t : '' ?>'>
                                      <?php
                                      $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                          'model' => $model,
                                          'attribute' => 'fped_end_date',
                                          'language' => strstr(Yii::app()->language . '_', '_', true),
                                          'htmlOptions' => array('size' => 10),
                                          'options' => array(
                                              'showButtonPanel' => true,
                                              'changeYear' => true,
                                              'changeYear' => true,
                                              'dateFormat' => 'yy-mm-dd',
                                          ),
                                              )
                                      );
                                      ;
                                      echo $form->error($model, 'fped_end_date')
                                      ?>                            </span>
                        </div>
                    </div>
<?php ?>

                    <?php ?>
                    <div class="control-group">
                        <div class='control-label'>
<?php echo $form->labelEx($model, 'fped_month') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                  title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fped_month')) != 'tooltip.fped_month') ? $t : '' ?>'>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'model' => $model,
    'attribute' => 'fped_month',
    'language' => strstr(Yii::app()->language . '_', '_', true),
    'htmlOptions' => array('size' => 10),
    'options' => array(
        'showButtonPanel' => true,
        'changeYear' => true,
        'changeYear' => true,
        'dateFormat' => 'yy-mm-dd',
    ),
        )
);
;
echo $form->error($model, 'fped_month')
?>                            </span>
                        </div>
                    </div>

                </div>
</div>                

                <!-- main inputs -->
                <div class="form-actions center">
<?php
$this->widget("bootstrap.widgets.TbButton", array(
    "label" => Yii::t("D2fixrModule.crud", "Save"),
    "icon" => "icon-thumbs-up icon-white",
    "size" => "small",
    "type" => "primary",
    "htmlOptions" => array(
        "onclick" => "$('#period_dialog_form').submit();",
    ),
        //"visible"=> (Yii::app()->user->checkAccess("D2finv.FpedPeriodDate.*") || Yii::app()->user->checkAccess("D2finv.FpedPeriodDate.View"))
));
?>

                </div>    

            </div>

<?php $this->endWidget(); ?>
        </div>

