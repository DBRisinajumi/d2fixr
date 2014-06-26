<?php
    $this->setPageTitle(
        Yii::t('D2fixrModule.model', 'Finv Dimension')
        . ' - '
        . Yii::t('D2fixrModule.crud_static', 'View')
        . ': '   
        . $model->getItemLabel()            
);    

$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:array("{$this->id}/admin"),
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
                <?php echo Yii::t('D2fixrModule.model','Finv Invoice');?>                <small><?php echo$model->itemLabel?></small>
            </h1>
        </div>
        <div class="btn-group">
            <?php
            
            $this->widget("bootstrap.widgets.TbButton", array(
                "label"=>Yii::t("D2fixrModule.crud_static","Delete"),
                "type"=>"danger",
                "icon"=>"icon-trash icon-white",
                "size"=>"large",
                "htmlOptions"=> array(
                    "submit"=>array("delete","finv_id"=>$model->{$model->tableSchema->primaryKey}, "returnUrl"=>(Yii::app()->request->getParam("returnUrl"))?Yii::app()->request->getParam("returnUrl"):$this->createUrl("admin")),
                    "confirm"=>Yii::t("D2fixrModule.crud_static","Do you want to delete this item?")
                ),
                "visible"=> (Yii::app()->request->getParam("finv_id")) && (Yii::app()->user->checkAccess("D2finv.FinvInvoice.*") || Yii::app()->user->checkAccess("D2finv.FinvInvoice.Delete"))
            ));
            ?>
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
                    'name' => 'finv_due_date',
                ),
                array(
                    'name' => 'finv_notes',
                ),
                array(
                    'name' => 'finv_fcrn_id',
                    'value' => $model->finvFcrn->fcrn_code,
                ),
                array(
                    'name' => 'finv_amt',
                ),
                /**
                 * @todo japieliek modeli relacija uz fvat
                 */     
                array(
                    'name' => 'finv_vat',
                ),

                array(
                    'name' => 'finv_total',
                ),
                array(
                    'name' => 'finv_basic_fcrn_id',
                    'value' => $model->finvBasicFcrn->fcrn_code,
                ),

                array(
                    'name' => 'finv_basic_amt',
                ),

                array(
                    'name' => 'finv_basic_vat',
                ),
                array(
                    'name' => 'finv_basic_total',
                ),

                array(
                    'name' => 'finv_type',
                    'value' => $model->getEnumLabel("finv_type",$model->finv_type),    
                ),
           ),
        )); ?>
    </div>


    <div class="span7">
            <?php $this->renderPartial('_view_finv_items',array('modelMain' => $model, 'ajax' => false,)); ?>        
    </div>
</div>

<?php echo $cancel_buton; ?>