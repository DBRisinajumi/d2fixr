<div class="crud-form">
    <?php
        //Yii::app()->bootstrap->registerPackage('select2');
        //Yii::app()->clientScript->registerScript('crud/variant/update','$("#vtls-trailer-service-form select").select2();');


        $form=$this->beginWidget('TbActiveForm', array(
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
           echo $form->hiddenField($model,'vtls_id'); 
        }   
        echo $form->hiddenField($model,'vtls_fixr_id');        
        
        echo $form->errorSummary($model);
    ?>
    

                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php  ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtls_id')) != 'tooltip.vtls_id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'vtls_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vtls_vtrl_id') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtls_vtrl_id')) != 'tooltip.vtls_vtrl_id')?$t:'' ?>'>
                                <?php
                            $this->widget(
                '\GtcRelation',
                array(
                    'model' => $model,
                    'relation' => 'vtlsVtrl',
                    'fields' => 'itemLabel',
                    'allowEmpty' => true,
                    'style' => 'dropdownlist',
                    'htmlOptions' => array(
                        'checkAll' => 'all'
                    ),
                )
                );
                            echo $form->error($model,'vtls_vtrl_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vtls_vsrv_id') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtls_vsrv_id')) != 'tooltip.vtls_vsrv_id')?$t:'' ?>'>
                                <?php
                            $this->widget(
                '\GtcRelation',
                array(
                    'model' => $model,
                    'relation' => 'vtlsVsrv',
                    'fields' => 'itemLabel',
                    'allowEmpty' => true,
                    'style' => 'dropdownlist',
                    'htmlOptions' => array(
                        'checkAll' => 'all'
                    ),
                )
                );
                            echo $form->error($model,'vtls_vsrv_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vtls_notes') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtls_notes')) != 'tooltip.vtls_notes')?$t:'' ?>'>
                                <?php
                            echo $form->textArea($model, 'vtls_notes', array('rows' => 6, 'cols' => 50));
                            echo $form->error($model,'vtls_notes')
                            ?>                            </span>
                        </div>
                    </div>
                
            </div>

    <?php 
    $this->endWidget();
