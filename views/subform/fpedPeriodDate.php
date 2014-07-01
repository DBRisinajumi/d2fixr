<div class="crud-form">
    <?php  ?>    
    <?php
        Yii::app()->bootstrap->registerPackage('select2');
        Yii::app()->clientScript->registerScript('crud/variant/update','$("#fped-period-date-form select").select2();');


        $form=$this->beginWidget('TbActiveForm', array(
            'id' => 'expense_data_form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'enctype' => ''
            )
        ));
        
        echo CHtml::hiddenField('frep_id', $frep_id);     
        echo CHtml::hiddenField('fixr_id', $fixr_id);     


        if(!$model->getIsNewRecord()){
           echo $form->hiddenField($model,'fped_id'); 
        }   
        echo $form->hiddenField($model,'fped_fixr_id');        

        echo $form->errorSummary($model);
    ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php  ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2finvModule.model', 'tooltip.fped_id')) != 'tooltip.fped_id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'fped_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'fped_start_date') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2finvModule.model', 'tooltip.fped_start_date')) != 'tooltip.fped_start_date')?$t:'' ?>'>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                         array(
                                 'model' => $model,
                                 'attribute' => 'fped_start_date',
                                 'language' =>  strstr(Yii::app()->language.'_','_',true),
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
                            echo $form->error($model,'fped_start_date')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'fped_end_date') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2finvModule.model', 'tooltip.fped_end_date')) != 'tooltip.fped_end_date')?$t:'' ?>'>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                         array(
                                 'model' => $model,
                                 'attribute' => 'fped_end_date',
                                 'language' =>  strstr(Yii::app()->language.'_','_',true),
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
                            echo $form->error($model,'fped_end_date')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'fped_month') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2finvModule.model', 'tooltip.fped_month')) != 'tooltip.fped_month')?$t:'' ?>'>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                         array(
                                 'model' => $model,
                                 'attribute' => 'fped_month',
                                 'language' =>  strstr(Yii::app()->language.'_','_',true),
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
                            echo $form->error($model,'fped_month')
                            ?>                            </span>
                        </div>
                    </div>
                
            </div>

        <!-- main inputs -->



    <?php $this->endWidget(); 
