
    <div class="widget-box no-padding">
        <div class="widget-header">
            <h4><?= Yii::t('D2fixrModule.model', 'Set expenses position') ?></h4>
        </div>
        <div class="widget-body">
            <div class="widget-main no-padding">

                <div class="form-horizontal">


                    <?php 
                $form = $this->beginWidget('TbActiveForm', array(
                    'id' => 'service_popup_form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'htmlOptions' => array(
                        'enctype' => ''
                    )
                ));                    
                    ?>
                    <div class="control-group"></div>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model_fixr, 'fixr_fret_id') ?>
                        </div>
                        <div class='controls'>
                                      <?php
                                      echo CHtml::dropDownList(
                                              'fret_id', 
                                              $model_fixr->fixr_fret_id,
                                              CHtml::listData(FretRefType::model()->findAll(array('order'=>'fret_label')), 'fret_id', 'fret_label'),
                                              array(
                                                  'id' => 'fret_id_'.$model_fixr->fixr_id.'_'.date('Hms'), //izveidots dinamisks id
                                                  'prompt' => Yii::t('D2fixrModule.model', 'Select service type'),
                                                  'ajax' => array(
                                                      'type' => 'GET',
                                                      'url' => $this->createUrl('FixrFiitXRef/ServiceSubForm',array('fixr_id'=>$model_fixr->fixr_id)),
                                                      'update' => '#ajax_form',
                                                      
                                                  ),
                                               )
                                              )
                                              ;
//                                        $this->widget(
//                                            'bootstrap.widgets.TbSelect2',
//                                            array(
//                                                //'model' => $model_fixr,
//                                                'name' => 'fixr_fret_id',                                                
//                                                'asDropDownList' => true,
//                                                'data' => CHtml::listData(FretRefType::model()->findAll(array('order'=>'fret_label')), 'fret_id', 'fret_label'),                                                
//                                                'options' => array(
//                                                    'placeholder' => Yii::t('D2fixrModule.model', 'Select service type'),
//
//                                                    //'tags' => array('clever', 'is', 'better', 'clevertech'),
//                                                    //'placeholder' => 'type clever, or is, or just type!',
//                                                    //'width' => '40%',
//                                                    //'tokenSeparators' => array(',', ' ')
//                                                )
//                                            )
//                                        );                                      

                                          
                                      ?>                            
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>

                </div>
                <div class="form-horizontal" id="ajax_form">
                    
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
        "onclick" => "$('#service_popup_form').submit();",
    ),
        //"visible"=> (Yii::app()->user->checkAccess("D2finv.FpedPeriodDate.*") || Yii::app()->user->checkAccess("D2finv.FpedPeriodDate.View"))
));
?>

                </div>    

            </div>


        </div>

