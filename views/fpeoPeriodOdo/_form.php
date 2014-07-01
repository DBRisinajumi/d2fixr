<div class="crud-form">
    <?php  ?>    
    <?php
        Yii::app()->bootstrap->registerPackage('select2');
        Yii::app()->clientScript->registerScript('crud/variant/update','$("#fpeo-period-odo-form select").select2();');


        $form=$this->beginWidget('TbActiveForm', array(
            'id' => 'fpeo-period-odo-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'enctype' => ''
            )
        ));

        echo $form->errorSummary($model);
    ?>
    
    <div class="row">
        <div class="span12">
            <h2>
                <?php echo Yii::t('D2fixrModule.crud','Data')?>                <small>
                    #<?php echo $model->fpeo_id ?>                </small>

            </h2>


            <div class="form-horizontal">

                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php  ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fpeo_id')) != 'tooltip.fpeo_id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'fpeo_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'fpeo_fixr_id') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fpeo_fixr_id')) != 'tooltip.fpeo_fixr_id')?$t:'' ?>'>
                                <?php
                            $this->widget(
                '\GtcRelation',
                array(
                    'model' => $model,
                    'relation' => 'fpeoFixr',
                    'fields' => 'itemLabel',
                    'allowEmpty' => true,
                    'style' => 'dropdownlist',
                    'htmlOptions' => array(
                        'checkAll' => 'all'
                    ),
                )
                );
                            echo $form->error($model,'fpeo_fixr_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'fpeo_start_abs_odo') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fpeo_start_abs_odo')) != 'tooltip.fpeo_start_abs_odo')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'fpeo_start_abs_odo', array('size' => 10, 'maxlength' => 10));
                            echo $form->error($model,'fpeo_start_abs_odo')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'fpeo_end_abs_odo') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fpeo_end_abs_odo')) != 'tooltip.fpeo_end_abs_odo')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'fpeo_end_abs_odo', array('size' => 10, 'maxlength' => 10));
                            echo $form->error($model,'fpeo_end_abs_odo')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'fpeo_distance') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fpeo_distance')) != 'tooltip.fpeo_distance')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'fpeo_distance', array('size' => 10, 'maxlength' => 10));
                            echo $form->error($model,'fpeo_distance')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                
            </div>
        </div>
        <!-- main inputs -->

            </div>
    <div class="row">
        
        <div class="span12"><!-- sub inputs -->
            <h2>
                <?php echo Yii::t('D2fixrModule.crud','Relations')?>            </h2>
            <div class="well">
                                        </div>
        </div>
        <!-- sub inputs -->
    </div>

    <p class="alert">
        <?php echo Yii::t('D2fixrModule.crud','Fields with <span class="required">*</span> are required.');?>
    </p>

    <!-- TODO: We need the buttons inside the form, when a user hits <enter> -->
    <div class="form-actions" style="visibility: hidden; height: 1px">
        
        <?php
            echo CHtml::Button(
            Yii::t('D2fixrModule.crud', 'Cancel'), array(
                'submit' => (isset($_GET['returnUrl']))?$_GET['returnUrl']:array('fpeoPeriodOdo/admin'),
                'class' => 'btn'
            ));
            echo ' '.CHtml::submitButton(Yii::t('D2fixrModule.crud', 'Save'), array(
                'class' => 'btn btn-primary'
            ));
        ?>
    </div>

    <?php $this->endWidget() ?>    <?php  ?></div> <!-- form -->
