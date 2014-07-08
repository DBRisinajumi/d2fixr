<h2><?= Yii::t('D2fixrModule.model', 'Invoce item dimensions') ?></h2>
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>

            <th><?= Yii::t('D2fixrModule.model', 'Fiit Desc') ?></th>
            <th><?= Yii::t('D2fixrModule.model', 'Fiit Quantity') ?></th>
            <th><?= Yii::t('D2fixrModule.model', 'Fiit Fqnt') ?></th>
            <th><?= Yii::t('D2fixrModule.model', 'Fiit Price') ?></th>
            <th><?= Yii::t('D2fixrModule.model', 'Fiit Amt') ?></th>
            <th><?= Yii::t('D2fixrModule.model', 'Fiit Vat') ?></th>
            <th><?= Yii::t('D2fixrModule.model', 'Fiit Total') ?></th>

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
        $this->widget('EFancyboxWidget',array(
            'selector'=>'a[href*=\'d2fixr/fixrFiitXRef/popupPosition\']',
            'options'=>array(
                //'height'         => 720,
                //'width'         => 500,
                'autoDimensions' => false,
                'autoScale' => true,
                'live' => false,
                'onClosed' => 'js:function(){            
                    var ajax_url = $(this).attr("href") + "&get_label=1";
                    var elThis = this;
                    $.ajax({
                                    type: "GET",
                                    url: ajax_url,
                                    success: function(data) {
                                        $(elThis).attr("orig").html(data);
                                    }   
                    });                      

                }'
            ),
        ));    
        
        $this->widget('EFancyboxWidget',array(
            'selector'=>'a[href*=\'d2fixr/fixrFiitXRef/popupPeriod\']',
            'options'=>array(
                //'height'         => 720,
                //'width'         => 500,
                'autoDimensions' => false,
                'autoScale' => true,
                'live' => false,
                'onClosed' => 'js:function(){            
                    var ajax_url = $(this).attr("href") + "&get_label=1";
                    var elThis = this;
                    $.ajax({
                                    type: "GET",
                                    url: ajax_url,
                                    success: function(data) {
                                        $(elThis).attr("orig").html(data);
                                    }   
                    });                      

                }'
            ),
        ));        
        
        
        foreach ($modelMain->fiitInvoiceItems as $fiit) {
            ?>
            <tr>
                <td><?= $fiit->fiit_desc ?></td>
                <td class="numeric-column"><?= $fiit->fiit_quantity ?></td>
                <td><?= $fiit->fiit_fqnt_id ?></td>
                <td class="numeric-column"><?= $fiit->fiit_price ?></td>
                <td class="numeric-column"><?= $fiit->fiit_amt ?></td>
                <td class="numeric-column"><?= $fiit->fiit_vat ?></td>
                <td class="numeric-column"><?= $fiit->fiit_total ?></td>
            </tr>
            <tr>
                <td colspan="7" class="rel_grid-sub">
                    <h3 class="rel_grid-sub">
                        <?php
                        
                        $sub_grid_id = 'fixr-grid-' . $fiit->primaryKey;
                        
                        /**
                         * @todo jāpārslēdz uz ajaxu atpakaļ, kad atrisinās fancy box linka iedarbināšanu jaunajam itemama
                         */
                        $this->widget(
                                'bootstrap.widgets.TbButton', array(
                                    //ajax: 'buttonType' => 'ajaxButton',
                                    'buttonType' => 'link',
                                    'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                                    'size' => 'mini',
                                    'icon' => 'icon-plus',
                                    'url' => array(
                                        '//d2fixr/fixrFiitXRef/ajaxCreate',
                                        'field' => 'fixr_fiit_id',
                                        'value' => $fiit->primaryKey,
                                        //ajax: 'ajax' => $sub_grid_id,
                                    ),
                                    //ajax: 'ajaxOptions' => array(
                                    //ajax:     'success' => 'function(html) {$.fn.yiiGridView.update(\'' . $sub_grid_id . '\');}'
                                    //ajax: ),
                                    'htmlOptions' => array(
                                        'title' => Yii::t('D2fixrModule.crud_static', 'Add new record'),
                                        'data-toggle' => 'tooltip',
                                    ),
                                )
                        );
                        ?>
                    </h3>                        
                    <?php
                    if (empty($fiit->fixrFiitXRefs)) {
                        $model = new FixrFiitXRef();
                        $model->fixr_fiit_id = $fiit->primaryKey;
                        $model->fixr_fcrn_date = $modelMain->finv_budget_date;
                        $model->fixr_fcrn_id = $modelMain->finv_fcrn_id;
                        $model->fixr_base_fcrn_id = $modelMain->finv_basic_fcrn_id;
                        $model->save();
                        unset($model);
                    }

                    $model = new FixrFiitXRef();
                    $model->fixr_fiit_id = $fiit->primaryKey;

                    $this->widget('TbGridView', array(
                        'id' => $sub_grid_id,
                        'dataProvider' => $model->search(),
                        'template' => '{summary}{items}',
                        'summaryText' => '&nbsp;',
                        'htmlOptions' => array(
                            'class' => 'rel-grid-view-sub'
                        ),
                        'columns' => array(
                            array(
                                //decimal(10,2)
                                'class' => 'editable.EditableColumn',
                                'name' => 'fixr_amt',
                                'editable' => array(
                                    'url' => $this->createUrl('/d2fixr/fixrFiitXRef/editableSaver'),
                                    //'placement' => 'right',
                                )
                            ),                            
                            array(
                                'header' => Yii::t('D2fixrModule.model','Position'),
                                'type' => 'raw',
                                'value' => 'CHtml::link($data->getFretLabel(),
                                                array(\'/d2fixr/fixrFiitXRef/popupPosition\',\'fixr_id\' =>$data->fixr_id)
                                            );'
                            ),
                            array(
                                'header' => Yii::t('D2fixrModule.model','Period'),
                                'type' => 'raw',
                                'value' => 'CHtml::link($data->getFrepLabel(),
                                                array(\'/d2fixr/fixrFiitXRef/popupPeriod\',\'fixr_id\' =>$data->fixr_id)
                                            );'
                            ),
                            array(
                                'class' => 'TbButtonColumn',
                                'buttons' => array(
                                    'view' => array('visible' => 'FALSE'),
                                    'update' => array('visible' => 'FALSE'),
                                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("D2finv.FretRefType.DeletefixrFiitXRefs")'),
                                ),
                                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/d2fixr/fixrFiitXRef/delete", array("fixr_id" => $data->fixr_id))',
                                'deleteButtonOptions' => array('data-toggle' => 'tooltip'),
                            ),
                        ),))
                    ?>


                </td>
            </tr>
    <?
}
?>
    </tbody>
</table>