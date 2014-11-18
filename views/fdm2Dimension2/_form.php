<div class="crud-form">
    <?php
        Yii::app()->bootstrap->registerPackage('select2');
        Yii::app()->clientScript->registerScript('crud/variant/update','$("#fdm2-dimension2-form select").select2();');


        $form=$this->beginWidget('TbActiveForm', array(
            'id' => 'fdm2-dimension2-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'enctype' => ''
            )
        ));
        echo $form->hiddenField($model, 'fdm2_fdm1_id');
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
                                 title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fdm2_id')) != 'tooltip.fdm2_id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'fdm2_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                                    
                    <?php if(false){ ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'fdm2_code') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fdm2_code')) != 'tooltip.fdm2_code')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'fdm2_code', array('size' => 10, 'maxlength' => 10));
                            echo $form->error($model,'fdm2_code')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  } ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'fdm2_name') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fdm2_name')) != 'tooltip.fdm2_name')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'fdm2_name', array('size' => 50, 'maxlength' => 50));
                            echo $form->error($model,'fdm2_name')
                            ?>                            </span>
                        </div>
                    </div>
                
                
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'fdm2_fret_id') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2fixrModule.model', 'tooltip.fdm2_fret_id')) != 'tooltip.fdm2_fret_id')?$t:'' ?>'>
                                <?php
                            
                            $find_all_param = array(
                                'order'=>'fret_label',
                                'condition'=>"fret_controller_action = 'FixrFiitXRef/popupPosition'",
                                );                                
                            $table_data = FretRefType::model()->findAll($find_all_param);
                            $list_data = CHtml::listData($table_data,'fret_id','fret_label');
                            echo $form->listBox($model,'fdm2_fret_id',$list_data,array('class'=>'span6'));
                            echo $form->error($model,'fdm2_fret_id')
                            ?>                            
                            </span>
                        </div>
                    </div>

                                    
            </div>
        </div>
        <!-- main inputs -->

        
    </div>

    <div class="alert">
        
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


    <?php $this->endWidget() ?>   
</div> <!-- form -->
