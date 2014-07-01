<?php
    $this->setPageTitle(
        Yii::t('D2finvModule.model', 'Fped Period Date')
        . ' - '
        . Yii::t('D2finvModule.crud', 'View')
        . ': '   
        . $model->getItemLabel()            
);    
//$this->breadcrumbs[Yii::t('D2finvModule.model','Fped Period Dates')] = array('admin');
//$this->breadcrumbs[$model->{$model->tableSchema->primaryKey}] = array('view','id' => $model->{$model->tableSchema->primaryKey});
//$this->breadcrumbs[] = Yii::t('D2finvModule.crud', 'View');
$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    #"label"=>Yii::t("D2finvModule.crud","Cancel"),
    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:array("{$this->id}/admin"),
    "visible"=>(Yii::app()->user->checkAccess("D2finv.FpedPeriodDate.*") || Yii::app()->user->checkAccess("D2finv.FpedPeriodDate.View")),
    "htmlOptions"=>array(
                    "class"=>"search-button",
                    "data-toggle"=>"tooltip",
                    "title"=>Yii::t("D2finvModule.crud","Back"),
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
                <?php echo Yii::t('D2finvModule.model','Fped Period Date');?>                <small><?php echo$model->itemLabel?></small>
            </h1>
        </div>
        <div class="btn-group">
            <?php
            
            $this->widget("bootstrap.widgets.TbButton", array(
                "label"=>Yii::t("D2finvModule.crud","Delete"),
                "type"=>"danger",
                "icon"=>"icon-trash icon-white",
                "size"=>"large",
                "htmlOptions"=> array(
                    "submit"=>array("delete","fped_id"=>$model->{$model->tableSchema->primaryKey}, "returnUrl"=>(Yii::app()->request->getParam("returnUrl"))?Yii::app()->request->getParam("returnUrl"):$this->createUrl("admin")),
                    "confirm"=>Yii::t("D2finvModule.crud","Do you want to delete this item?")
                ),
                "visible"=> (Yii::app()->request->getParam("fped_id")) && (Yii::app()->user->checkAccess("D2finv.FpedPeriodDate.*") || Yii::app()->user->checkAccess("D2finv.FpedPeriodDate.Delete"))
            ));
            ?>
        </div>
    </div>
</div>



<div class="row">
    <div class="span12">
        <h2>
            <?php echo Yii::t('D2finvModule.crud','Data')?>            <small>
                #<?php echo $model->fped_id ?>            </small>
        </h2>

        <?php
        $this->widget(
            'TbDetailView',
            array(
                'data' => $model,
                'attributes' => array(
                
                array(
                    'name' => 'fped_id',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'fped_id',
                            'url' => $this->createUrl('/d2finv/fpedPeriodDate/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'fped_fixr_id',
                    'type' => 'raw',    
                    'value' => $this->widget(
                        'EditableField', 
                        array(
                            'model' => $model,
                            'type' => 'select',
                            'url' => $this->createUrl('/d2finv/fpedPeriodDate/editableSaver'),
                            'source' => CHtml::listData(FixrFiitXRef::model()->findAll(array('limit' => 1000)), 'fixr_id', 'itemLabel'),                        
                            'attribute' => 'fped_fixr_id',
                            //'placement' => 'right',                                
                        ), 
                        true
                    )                   
                ),

                array(
                    'name' => 'fped_start_date',
                    'type' => 'raw',    
                    'value' => $this->widget(
                        'EditableField', 
                        array(
                            'model' => $model,
                            'type' => 'date',
                            'url' => $this->createUrl('/d2finv/fpedPeriodDate/editableSaver'),
                            'attribute' => 'fped_start_date',
                            //'placement' => 'right',                                
                        ), 
                        true
                    )                   
                ),

                array(
                    'name' => 'fped_end_date',
                    'type' => 'raw',    
                    'value' => $this->widget(
                        'EditableField', 
                        array(
                            'model' => $model,
                            'type' => 'date',
                            'url' => $this->createUrl('/d2finv/fpedPeriodDate/editableSaver'),
                            'attribute' => 'fped_end_date',
                            //'placement' => 'right',                                
                        ), 
                        true
                    )                   
                ),

                array(
                    'name' => 'fped_month',
                    'type' => 'raw',    
                    'value' => $this->widget(
                        'EditableField', 
                        array(
                            'model' => $model,
                            'type' => 'date',
                            'url' => $this->createUrl('/d2finv/fpedPeriodDate/editableSaver'),
                            'attribute' => 'fped_month',
                            //'placement' => 'right',                                
                        ), 
                        true
                    )                   
                ),
           ),
        )); ?>
    </div>

    </div>
    <div class="row">

    <div class="span12">
        <div class="well">
            <?php $this->renderPartial('_view-relations_grids',array('modelMain' => $model, 'ajax' => false,)); ?>        </div>
    </div>
</div>

<?php echo $cancel_buton; ?>