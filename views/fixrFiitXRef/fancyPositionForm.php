<div class="widget-box no-padding">
    
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
                                        'url' => $this->createUrl('FixrFiitXRef/ShowPositionSubForm', array('fixr_id' => $model_fixr->fixr_id)),
                                        'update' => '#ajax_form',
                                    ),
                                )
                        );
                        ?>                            
                    </div>
                </div>
                <?php $this->endWidget(); ?>

            </div>


            <div class="form-horizontal" id="ajax_form">
                <?php $this->actionShowPositionSubForm($model_fixr->fixr_fret_id,$model_fixr->fixr_id); ?>
            </div>

            <div class="form-actions center no-margin">
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
           $ajax_submit_url = $this->createUrl('FixrFiitXRef/SavePositionSubForm');
                $this->widget("bootstrap.widgets.TbButton", array(
                    "label" => Yii::t("D2finvModule.crud_static", "Save"),
                    "icon" => "icon-thumbs-up icon-white",
                    "size" => "btn-small",
                    "type" => "primary",
                    "htmlOptions" => array(
                       "onclick"=>' 
                            $.ajax({
                                    type: "POST",
                                    url: "' . $ajax_submit_url . '",
                                    data: $("#expense_data_form").serialize(), // read and prepare all form fields
                                    success: function(data) {
                                            $("#mydialog").dialog("close");
                                            var ajax_url = "index.php?r=d2fixr/fixrFiitXRef/popupPosition&fixr_id=1&lang=en&get_label=1";
                                            var elThis = this;
                                            $.ajax({
                                                    type: "GET",
                                                    url: ajax_url,
                                                    success: function(data) {
                                                        //$(elThis).attr("orig").html(data);
                                                        $("#ccccc").html(data);
                                                        //var el = $("#mydialog").data("opener");
                                                        //$(el).attr("href")
    
                                                    }   
                                            });                      

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

