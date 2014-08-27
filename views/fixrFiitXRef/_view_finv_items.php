<h2><?= Yii::t('D2fixrModule.model', 'Items expense positions') ?></h2>
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>

            <th><?= Yii::t('D2finvModule.model', 'Fiit Desc') ?></th>
            <th><?= Yii::t('D2finvModule.model', 'Fiit Quantity') ?></th>
            <th><?= Yii::t('D2finvModule.model', 'Fiit Fqnt') ?></th>
            <th><?= Yii::t('D2finvModule.model', 'Fiit Price') ?></th>
            <th><?= Yii::t('D2finvModule.model', 'Fiit Amt') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!$ajax) {
            Yii::app()->clientScript->registerCss('rel_grid', ' 
            .rel-grid-view-sub {padding-top:0px;margin-top: -30px;}
            h3.rel_grid-sub{padding-left: 40px;margin-top: 0px;}
            td.rel_grid-sub{padding-top: 0px; border-top-width: 0px;}
            ');
        }
     
        foreach ($modelMain->fiitInvoiceItems as $fiit) {
            ?>
            <tr>
                <td><?= $fiit->fiit_desc ?></td>
                <td class="numeric-column"><?= $fiit->fiit_quantity ?></td>
                <td><?= $fiit->fiit_fqnt_id ?></td>
                <td class="numeric-column"><?= $fiit->fiit_price ?></td>
                <td class="numeric-column"><?= $fiit->fiit_amt ?></td>
            </tr>
            <tr>
                <td colspan="5" class="rel_grid-sub">
                    <h3 class="rel_grid-sub">
                        <?php
                        
                        $sub_grid_id = 'fixr-grid-' . $fiit->primaryKey;

                        $this->widget(
                                'bootstrap.widgets.TbButton', array(
                                    'buttonType' => 'ajaxButton',
                                    'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                                    'size' => 'mini',
                                    'icon' => 'icon-plus',
                                    'url' => array(
                                        '//d2fixr/fixrFiitXRef/ajaxCreate',
                                        'field' => 'fixr_fiit_id',
                                        'value' => $fiit->primaryKey,
                                        'ajax' => $sub_grid_id,
                                    ),
                                    'ajaxOptions' => array(
                                        'success' => 'function(html) {$.fn.yiiGridView.update(\'' . $sub_grid_id . '\');}'
                                    ),
                                    'htmlOptions' => array(
                                        'title' => Yii::t('D2fixrModule.crud', 'Add new record'),
                                        'data-toggle' => 'tooltip',
                                    ),
                                )
                        );
                        ?>
                    </h3>                        
                    <?php
                    if (empty($fiit->fixrFiitXRefs)) {
                        $model = new FixrFiitXRef;
                        $model->addRecord($fiit->primaryKey);
                        unset($model);
                    }

                    $model = new FixrFiitXRef();
                    $model->fixr_fiit_id = $fiit->primaryKey;
                    
                    $this->renderPartial('_fixr_grid',array(
                        'model' => $model,
                        'sub_grid_id' => $sub_grid_id,
                        ));

                    ?>


                </td>
            </tr>
    <?
}
?>
    </tbody>
</table>

<?

//Yii::app()->clientScript->registerScript('PositionDialogOnClose', 
//   '
//       $("#PositionDialog").live("pagehide",function(event) {
//          console.log("pagehide");
//       })   
//    '    
//      
//);
$ajax_submit_url = $this->createUrl('FixrFiitXRef/SavePositionSubForm');        
$this->beginWidget('vendor.uldisn.ace.widgets.CJuiAceDialog',array(
    'id'=>'PositionDialog',
    'title' => Yii::t('D2fixrModule.model', 'Set expenses position'),
    //'title_icon' => 'icon-warning-sign red',
    'options'=>array(
        'resizable' => true,
        'width'=>'auto',
        'height'=>'auto',        
        'modal' => true,
        'autoOpen'=>false,
    ),
));

$this->endWidget('vendor.uldisn.ace.widgets.CJuiAceDialog');

$this->beginWidget('vendor.uldisn.ace.widgets.CJuiAceDialog',array(
    'id'=>'PeriodDialog',
    'title' => Yii::t('D2fixrModule.model', 'Set expenses period'),
    //'title_icon' => 'icon-warning-sign red',
    'options'=>array(
        'resizable' => true,
        'width'=>'auto',
        'height'=>'auto',        
        'modal' => true,
        'autoOpen'=>false,
        'onclose' => 'function(event, ui) {$("#ajax_form").html("");}'
    ),
));

$this->endWidget('vendor.uldisn.ace.widgets.CJuiAceDialog');

Yii::app()->clientScript->registerScript('ui_position_click', 
   '
       $(document ).on("click","a[href*=\'d2fixr/fixrFiitXRef/popupPosition\']",function() {
          var ui_dialog_ajax_url = $(this).attr("href");
          $("#ui_position_box").html("");
          $("#PositionDialog").data("opener", this).load(ui_dialog_ajax_url).dialog("open"); 
          return false;
       })   
       $(document ).on("click","a[href*=\'d2fixr/fixrFiitXRef/popupPeriod\']",function() {
          var ui_dialog_ajax_url = $(this).attr("href");
          //$("#ui_period_box").html("");
          $("#PeriodDialog").data("opener", this).load(ui_dialog_ajax_url).dialog("open"); 
          return false;
       })   
    '    
      
);
