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
                            $model_fixr->fixr_fret_id, CHtml::listData($model_fret, 'fret_id', 'fret_label'), 
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
            <?php $this->actionShowPositionSubForm($model_fixr->fixr_fret_id, $model_fixr->fixr_id); ?>
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
                "size" => "btn-small",
                "type" => "primary",
                "htmlOptions" => array(
                    "onopen" => ' alert( $.data(this, "opener"));',
                    "onclick" => ' 
                    $.ajax({
                            type: "POST",
                            url: "' . $ajax_submit_url . '",
                            data: $("#expense_data_form").serialize(), // read and prepare all form fields
                            success: function(data) {

                                    //get openner href
                                    $("#mydialog").dialog("close");
                                    var opener = $("#mydialog").data("opener");
                                    var href = $(opener).attr("href");

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
                    //"visible"=> (Yii::app()->user->checkAccess("D2finv.FinvInvoice.*") || Yii::app()->user->checkAccess("D2finv.FinvInvoice.View"))
            ));
            ?>

        </div>    
    </div>                
</div>

