<div class="crud-form">
    <?php  ?>    
    <?php
        Yii::app()->bootstrap->registerPackage('select2');
        Yii::app()->clientScript->registerScript('crud/variant/update','$("#fdm1-dimension1-form select").select2();');


        $form=$this->beginWidget('TbActiveForm', array(
            'id' => 'fdm1-dimension1-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'enctype' => ''
            )
        ));

        echo $form->errorSummary($model);
    ?>
    
    <div class="row">
        <div class="span5">
            <div class="form-horizontal">

                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php  ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fdm1_id')) != 'tooltip.fdm1_id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'fdm1_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php if(false){ ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'fdm1_code') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fdm1_code')) != 'tooltip.fdm1_code')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'fdm1_code', array('size' => 10, 'maxlength' => 10));
                            echo $form->error($model,'fdm1_code')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php } ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'fdm1_name') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fdm1_name')) != 'tooltip.fdm1_name')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'fdm1_name', array('size' => 50, 'maxlength' => 50));
                            echo $form->error($model,'fdm1_name')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                
            </div>
        </div>
        <!-- main inputs -->

        
    </div>

    <div class="alert alert-warning">
        
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
    </div>


    <?php $this->endWidget() ?>    <?php  ?></div> <!-- form -->
