<div class="widget-box no-padding" id="ui_period_box">

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
                    <?php echo $form->labelEx($model_fixr, 'fixr_period_fret_id') ?>
                </div>
                <div class='controls'>
                    <?php
                    $fret_id = $model_fixr->fixr_period_fret_id;
                    $ajax_url = $this->createUrl('FixrFiitXRef/ShowPositionSubForm', array('fixr_id' => $model_fixr->fixr_id));                    
                    $fret_id_list_box_id = 'fret_id_' . $model_fixr->fixr_id . '_' . date('Hms');
                    echo CHtml::dropDownList(
                            'fret_id', 
                            $fret_id, CHtml::listData($model_fret, 'fret_id', 'fret_label'), 
                            array(
                                'id' => $fret_id_list_box_id, //izveidots dinamisks id
                                'prompt' => Yii::t('D2fixrModule.model', 'Select type'),
                                'ajax' => array(
                                    'type' => 'GET',
                                    'url' => $ajax_url,
                                    'update' => '#ui_period_ajax_form',
                                ),
                            )
                    );
                    Yii::app()->clientScript->registerScript(
                      'update-ui-period-ajax-form',
                      '
                          $(document).ready(function() {
                            $.ajax({
                                url: "'.$ajax_url.'",
                                type: "GET",
                                data: {fret_id:"'.$fret_id.'"},
                                success: function(result){
                                    $("#ui_period_ajax_form").html(result);
                                  }});
                            });
                        '
                    );                    
                    ?>                            
                </div>
            </div>
            <?php $this->endWidget(); ?>

        </div>

        <div class="form-horizontal" id="ui_period_ajax_form">
        </div>

        <div class="form-actions center no-margin">
            <?php
            /**
             * submit UI form, close it and change opener text
             */
            $ajax_submit_url = $this->createUrl('FixrFiitXRef/SavePositionSubForm');
            $this->widget("bootstrap.widgets.TbButton", array(
                "label" => Yii::t("D2finvModule.crud_static", "Save"),
                "icon" => "icon-thumbs-up icon-white",
                "id" => "ui_period_ajax_form_submit_buttn",
                "size" => "btn-small",
                "type" => "primary",
                "htmlOptions" => array(
                    "onclick" => ' 
                    $.ajax({
                            type: "POST",
                            url: "' . $ajax_submit_url . '",
                            data: $("#expense_data_form").serialize(), // read and prepare all form fields
                            success: function(data) {

                                    $("#ui_period_ajax_form").html("");
                                    
                                    //get dialog id
                                    var dialog_id= $("div.ui-dialog-content:visible").attr("id");
                                    
                                    //opener html tag
                                    var opener = $("#"+dialog_id).data("opener");
                                    
                                    //opener href
                                    var href  = $(opener).attr("href");
                                    $("#"+dialog_id).dialog("close");

                                    //by ajax get new label for opener
                                    var ajax_url = href + "&get_label=1";
                                    var elThis = this;
                                    $.ajax({
                                            type: "GET",
                                            url: ajax_url,
                                            success: function(data) {
                                                //fix opener label
                                                $(\'a[href="\'+href+\'"]\').html(data);                                    
                                            }   
                                    });                      

                            }   
                    });                                 
                    ',
                ),
            ));
            ?>

        </div>    
    </div>                
</div>

