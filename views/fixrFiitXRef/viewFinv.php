<?php
    $this->setPageTitle(Yii::t('D2fixrModule.model', 'Invoice expension positions'));

$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:array("{$this->id}/FinvInvoice"),
    "visible"=>(Yii::app()->user->checkAccess("D2finv.FinvInvoice.*") || Yii::app()->user->checkAccess("D2finv.FinvInvoice.View")),
    "htmlOptions"=>array(
                    "class"=>"search-button",
                    "data-toggle"=>"tooltip",
                    "title"=>Yii::t("D2fixrModule.crud_static","Back"),
                )
 ),true);
    
?>
<?php //$this->widget("TbBreadcrumbs", array("links"=>$this->breadcrumbs)) ?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('D2fixrModule.model','Invoice expension positions') . ' ' . $model->finvBasicFcrn->fcrn_code;?>
            </h1>
        </div>
    </div>
</div>



<div class="row">
    <div class="span5">

        <?php
        $this->widget(
            'TbDetailView',
            array(
                'data' => $model,
                'attributes' => array(

                array(
                    'name' => 'finv_series_number',
                ),
                array(
                    'name' => 'finv_number',
                ),
                array(
                    'name' => 'finv_type',
                    'value' => $model->getEnumLabel("finv_type",$model->finv_type),    
                ),                    
                array(
                    'name' => 'finv_ccmp_id',
                    'value' => $model->finvCcmp->ccmp_name,
                ),
                array(
                    'name' => 'finv_date',
                ),
                array(
                    'name' => 'finv_budget_date',
                ),
                array(
                    'name' => 'finv_notes',
                ),

                array(
                    'name' => 'finv_basic_amt',
                ),
           ),
        )); ?>
    </div>


    <div class="span7">
            <?php $this->renderPartial('_view_finv_items',array('modelMain' => $model, 'ajax' => false,)); ?>        
    </div>
</div>

<?php echo $cancel_buton; ?>