<div class="crud-form">
    <?php
        Yii::app()->bootstrap->registerPackage('select2');
        Yii::app()->clientScript->registerScript('crud/variant/update','$("#fdm3-dimension3-form select").select2();');


        $form=$this->beginWidget('TbActiveForm', array(
            'id' => 'fdm3-dimension3-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'enctype' => ''
            )
        ));

        echo $form->hiddenField($model, 'fdm3_fdm2_id');        
        echo $form->hiddenField($model, 'fdm3_fret_id');        
        echo $form->errorSummary($model);
    ?>
    
    <div class="row">
        <div class="span12">
            <div class="form-horizontal">

                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php  ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fdm3_id')) != 'tooltip.fdm3_id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'fdm3_id')
                            ?>                            </span>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'fdm3_code') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fdm3_code')) != 'tooltip.fdm3_code')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'fdm3_code', array('size' => 10, 'maxlength' => 10));
                            echo $form->error($model,'fdm3_code')
                            ?>                            </span>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'fdm3_name') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fdm3_name')) != 'tooltip.fdm3_name')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'fdm3_name', array('size' => 50, 'maxlength' => 50));
                            echo $form->error($model,'fdm3_name')
                            ?>                            </span>
                        </div>
                    </div>
                
            </div>
        </div>
        <!-- main inputs -->

            </div>
    <div class="row">
        
    </div>

    <p class="alert">
        
        <?php 
            echo Yii::t('D2fixrModule.crud','Fields with <span class="required">*</span> are required.');
                
            /**
             * @todo: We need the buttons inside the form, when a user hits <enter>
             */                
            echo ' '.CHtml::submitButton(Yii::t('D2fixrModule.crud', 'Save'), array(
                'class' => 'btn btn-primary',
                'style'=>'visibility: hidden;'                
            ));
                
        ?>
    </p>


    <?php $this->endWidget() ?>    <?php  ?></div> <!-- form -->
