
<div class="widget-box no-padding">
    <?php
    if (false) {
        ?>
        <div class="widget-header">
            <h4><?= Yii::t('D2fixrModule.model', 'Set expenses position') ?></h4>
        </div>
        <?php
    }
    ?>        
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
                        <?php echo $form->labelEx($model_fixr, 'Set expenses positon') ?>
                    </div>
                    <div class='controls'>
                        <?php
                        $fret_id_list_box_id = 'fret_id_' . $model_fixr->fixr_id . '_' . date('Hms');
                        echo CHtml::dropDownList(
                                'fret_id', 
                                $model_fixr->fixr_fret_id, 
                                CHtml::listData(FretRefType::model()->findAll(array('order' => 'fret_label')), 'fret_id', 'fret_label'), 
                                array(
                                    'id' => $fret_id_list_box_id, //izveidots dinamisks id
                                    'prompt' => Yii::t('D2fixrModule.model', 'Select service type'),
                                    'ajax' => array(
                                        'type' => 'GET',
                                        'url' => $this->createUrl('FixrFiitXRef/ShowSubForm', array('fixr_id' => $model_fixr->fixr_id)),
                                        'update' => '#ajax_form',
                                    ),
                                )
                        );
                        ?>                            
                    </div>
                </div>
                <?php $this->endWidget(); ?>

            </div>


            <div class="form-horizontal" id="ajax_form"></div>

            <div class="form-actions center">
                <?php
//        Yii::app()->clientScript->registerScript('fancybox_submit_form', '  
//                function submit_expense_data_form(){
//                    $.ajax({
//                            type: "POST",
//                            url: "' . $ajax_submit_url . '&fret_id="+$(\'[id*="fret_id_"]\'),
//                            data: $("#expense_data_form").serialize(), // read and prepare all form fields
//                            success: function(data) {
//                                    // trigger fancybox close on same modal window 
//                                    $.fancybox.close(); 
//                                    //$("#fancybox-close").click();
//                                    // trigger fancybox close from parent window
//                                    // parent.$.fancybox.close()
//                            }   
//                    });                      
//                }    
//                     ');               
           $ajax_submit_url = $this->createUrl('FixrFiitXRef/SaveSubForm');
                $this->widget("bootstrap.widgets.TbButton", array(
                    "label" => Yii::t("D2finvModule.crud_static", "Save"),
                    "icon" => "icon-thumbs-up icon-white",
                    "size" => "large",
                    "type" => "primary",
                    "htmlOptions" => array(
                        //"onclick" => "$('#expense_data_form').submit();",
                        //"onclick"=>"submit_expense_data_form();",
                       "onclick"=>' 
                            $.ajax({
                                    type: "POST",
                                    url: "' . $ajax_submit_url . '",
                                    data: $("#expense_data_form").serialize(), // read and prepare all form fields
                                    success: function(data) {
                                            // trigger fancybox close on same modal window 
                                            alert("success");
                                            //$.fancybox.close(); 
                                            //$.fn.fancybox.close();
                                            parent.jQuery.fancybox.close();
                                            //$("#fancybox-close").click();
                                            // trigger fancybox close from parent window
                                            // parent.$.fancybox.close()
                                    }   
                    });                                 
                           ' ,
                    ),
                        //"visible"=> (Yii::app()->user->checkAccess("D2finv.FinvInvoice.*") || Yii::app()->user->checkAccess("D2finv.FinvInvoice.View"))
                ));
                ?>

            </div>    
        </div>                
    </div>
</div>

