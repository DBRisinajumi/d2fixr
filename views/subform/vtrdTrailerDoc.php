<div class="crud-form">
    <?php
        //Yii::app()->bootstrap->registerPackage('select2');
        //Yii::app()->clientScript->registerScript('crud/variant/update','$("#vtrd-trailer-doc-form select").select2();');

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
           echo $form->hiddenField($model,'vtrd_id'); 
        }   
        echo $form->hiddenField($model,'vtrd_fixr_id');        
        
        echo $form->errorSummary($model);
    ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php  ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtrd_id')) != 'tooltip.vtrd_id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'vtrd_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vtrd_vtrl_id') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtrd_vtrl_id')) != 'tooltip.vtrd_vtrl_id')?$t:'' ?>'>
                                <?php
                            $this->widget(
                '\GtcRelation',
                array(
                    'model' => $model,
                    'relation' => 'vtrdVtrl',
                    'fields' => 'itemLabel',
                    'allowEmpty' => true,
                    'style' => 'dropdownlist',
                    'htmlOptions' => array(
                        'checkAll' => 'all'
                    ),
                )
                );
                            echo $form->error($model,'vtrd_vtrl_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vtrd_vtdt_id') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtrd_vtdt_id')) != 'tooltip.vtrd_vtdt_id')?$t:'' ?>'>
                                <?php
                            $this->widget(
                '\GtcRelation',
                array(
                    'model' => $model,
                    'relation' => 'vtrdVtdt',
                    'fields' => 'itemLabel',
                    'allowEmpty' => true,
                    'style' => 'dropdownlist',
                    'htmlOptions' => array(
                        'checkAll' => 'all'
                    ),
                )
                );
                            echo $form->error($model,'vtrd_vtdt_id')
                            ?>                            </span>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vtrd_number') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtrd_number')) != 'tooltip.vtrd_number')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'vtrd_number', array('size' => 50, 'maxlength' => 50));
                            echo $form->error($model,'vtrd_number')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vtrd_issue_date') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtrd_issue_date')) != 'tooltip.vtrd_issue_date')?$t:'' ?>'>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                         array(
                                 'model' => $model,
                                 'attribute' => 'vtrd_issue_date',
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
                            echo $form->error($model,'vtrd_issue_date')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vtrd_expire_date') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtrd_expire_date')) != 'tooltip.vtrd_expire_date')?$t:'' ?>'>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                         array(
                                 'model' => $model,
                                 'attribute' => 'vtrd_expire_date',
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
                            echo $form->error($model,'vtrd_expire_date')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'vtrd_notes') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('TrucksModule.model', 'tooltip.vtrd_notes')) != 'tooltip.vtrd_notes')?$t:'' ?>'>
                                <?php
                            echo $form->textArea($model, 'vtrd_notes', array('rows' => 6, 'cols' => 50));
                            echo $form->error($model,'vtrd_notes')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                
            </div>
    <?php 
    $this->endWidget();
