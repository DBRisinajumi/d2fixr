<?php

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    filter_FinvInvoice_finv_date_range_init();
   }
");

$fcrn_model = FcrnCurrency::model()->findByPk(Yii::app()->sysCompany->getAttribute('base_fcrn_id'));
$title = Yii::t('D2fixrModule.model', 'Invoices expense postions') . ' - ' . $fcrn_model->fcrn_code;
$this->setPageTitle( $title);


?>

<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo $title;?>
            </h1>
        </div>
    </div>
</div>

<?php Yii::beginProfile('FinvInvoice.view.grid'); 

$this->widget('TbGridView',
    array(
        'id' => 'finv-invoice-grid',
        'dataProvider' => $model->search(),
        'rowCssClassExpression' => '($data->finv_basic_amt != FixrFiitXRef::totalByFinvId($data->finv_id)) ? "alert alert-danger" : ""',
        'filter' => $model,
        #'responsiveTable' => true,
        'template' => '{summary}{pager}{items}{pager}',
        'pager' => array(
            'class' => 'TbPager',
            'displayFirstAndLast' => true,
        ),
        'afterAjaxUpdate' => 'reinstallDatePicker',
        'columns' => array(

            array(
                'name' => 'finv_number',
            ),
            array(
                'name' => 'finv_ccmp_id',
                'value' => 'CHtml::value($data, \'finvCcmp.itemLabel\')',
                'filter' => CHtml::listData(CcmpCompany::model()->findAll(array('limit' => 1000,'order'=>'ccmp_name')), 'ccmp_id', 'itemLabel'),
            ),
            array(
                'name' => 'finv_date',
                'filter' => $this->widget(
                    'vendor.dbrisinajumi.DbrLib.widgets.TbFilterDateRangePicker', 
                    array(
                       'model' => $model,
                       'attribute' => 'finv_date_range',
                       'options' => array(
                           'ranges' => array('today','yesterday','this_week','last_week','this_month','last_month','this_year'),
                       )
                    ),
                    TRUE 
                )
            ),
            /*
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
            ),*/
            array(
                //'class' => 'editable.EditableColumn',
                'name' => 'finv_stst_id',
                'value' => 'CHtml::value($data, \'finvStst.itemLabel\')',
                'filter' => CHtml::listData(StstState::model()->findAll(array('limit' => 1000)), 'stst_id', 'itemLabel'),
                //'editable' => array(
                //    'type' => 'select',
                //    'url' => $this->createUrl('/d2finv/finvInvoice/editableSaver'),
                //    'source' => CHtml::listData(StstState::model()->findAll(array('limit' => 1000)), 'stst_id', 'itemLabel'),                        
                //    //'placement' => 'right',
                //)
            ),            
            array(
                //decimal(10,2)
                'htmlOptions' => array('class' => 'numeric-column'),
                'name' => 'finv_basic_amt',
                'footer' => $model->getTotals('finv_amt'),
                'footerHtmlOptions' => array('class' => 'total-row numeric-column'),
            ),
            array(
                //decimal(10,2)
                'header' => Yii::t('D2fixrModule.model', 'Expenses Amount'),
                'htmlOptions' => array('class' => 'numeric-column'),
                'value' => 'FixrFiitXRef::totalBaseAmtByFinvId($data->finv_id)',
                //'footer' => $model->getTotals('finv_amt'),
                //'footerHtmlOptions' => array('class' => 'total-row numeric-column'),
            ),
            /*
            array(
                //decimal(10,2)
                'htmlOptions' => array('class' => 'numeric-column'),
                'name' => 'finv_vat',
                'footer' => $model->getTotals('finv_vat'),
                'footerHtmlOptions' => array('class' => 'total-row numeric-column'),
            ),
            array(
                //decimal(10,2)
                'htmlOptions' => array('class' => 'numeric-column'),
                'name' => 'finv_total',
                'footer' => $model->getTotals('finv_total'),
                'footerHtmlOptions' => array('class' => 'total-row numeric-column'),
            ),
            array(
                'name' => 'finv_basic_fcrn_id',
            ),
            array(
                //decimal(10,2)
                'name' => 'finv_basic_amt',
            ),
            array(
                //decimal(10,2)
                'name' => 'finv_basic_vat',
            ),
            array(
                //decimal(10,2)
                'name' => 'finv_basic_total',
            ),
            array(
                //decimal(10,2)
                'name' => 'finv_basic_payment_before',
            ),*/

            /*array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'finv_ref',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('/d2finv/finvInvoice/editableSaver'),
                        'source' => $model->getEnumFieldLabels('finv_ref'),
                        //'placement' => 'right',
                    ),
                   'filter' => $model->getEnumFieldLabels('finv_ref'),
                ),
            array(
                //int(10) unsigned
                'class' => 'editable.EditableColumn',
                'name' => 'finv_ref_id',
                'editable' => array(
                    'url' => $this->createUrl('/d2finv/finvInvoice/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'finv_type',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('/d2finv/finvInvoice/editableSaver'),
                        'source' => $model->getEnumFieldLabels('finv_type'),
                        //'placement' => 'right',
                    ),
                   'filter' => $model->getEnumFieldLabels('finv_type'),
                ),
            */

            array(
                'class' => 'TbButtonColumn',
                //'template'=>'{view}',
                'buttons' => array(
                    'view' => array('visible' => 'TRUE'),
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'FALSE'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("FixrFiitXRef/viewFinv", array("finv_id" => $data->finv_id))',
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),

            ),
        )
    )
);
?>
<?php Yii::endProfile('FinvInvoice.view.grid'); ?>