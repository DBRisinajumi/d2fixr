<?php


class FixrFiitXRefController extends Controller
{
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";
    public $menu_route = "d2fixr/FixrFiitXRef/FinvInvoice";   

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
         return array(
            array(
                'allow',
                'actions' => array('popupPosition','popupPeriod','ShowPositionSubForm','ShowPeriodSubForm','savePositionSubForm','savePeriodSubForm','create', 'admin', 'view', 'update', 'editableSaver', 'delete','ajaxCreate','viewFinv'),
                'roles' => array('D2finv.FixrFiitXRef.*'),
            ),
            array(
                'allow',
                'actions' => array('create','ajaxCreate'),
                'roles' => array('D2finv.FixrFiitXRef.Create'),
            ),
            array(
                'allow',
                'actions' => array('view','finvInvoice', 'admin','FixrFiitXRef'), // let the user view the grid
                'roles' => array('D2finv.FixrFiitXRef.View'),
            ),
            array(
                'allow',
                'actions' => array('update', 'editableSaver','viewFinv'),
                'roles' => array('D2finv.FixrFiitXRef.Update'),
            ),
            array(
                'allow',
                'actions' => array('delete'),
                'roles' => array('D2finv.FixrFiitXRef.Delete'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    
    /**
     * Create popup with service type listbox and ajax loading form
     * render partial for ajax
     * @param int $fixr_id
     */
    public function actionPopupPosition($fixr_id,$get_label = false)
    {

        $model_fixr = FixrFiitXRef::model()->findByPk($fixr_id);
        
        //for ajax get caller position label an if need period
        if($get_label && $model_fixr){
            $labels = $model_fixr->getPositionLabel(true);
            $this->renderJSON($labels);
        }
        
        $criteria = new CDbCriteria;
        $criteria->compare('fret_finv_type',$model_fixr->fixrFiit->fiitFinv->finv_type);
        $criteria->compare('fret_controller_action',$this->id.'/'.$this->action->id);
        $criteria->order = 'fret_label';
        $model_fret = FretRefType::model()->findAll($criteria);
        
        $cs = Yii::app()->clientScript;
        $cs->reset();        
        $cs->scriptMap = array(
            'jquery.js' => false, // prevent produce jquery.js in additional javascript data
            'jquery.min.js' => false,
        );        
        
        echo $this->renderPartial(
                'uiDialogPositionForm', 
                array(
                    'model_fixr' => $model_fixr,
                    'model_fret' => $model_fret,
                ),
                true,
                true);
    }    

    /**
     * Create popup with service type listbox and ajax loading form
     * render partial for ajax
     * @param int $fixr_id
     */
    public function actionPopupPeriod($fixr_id,$get_label = false)
    {

         $model_fixr = FixrFiitXRef::model()->findByPk($fixr_id);
        
        //for ajax get caller label
        if($get_label){
            if($model_fixr){
                echo $model_fixr->getPeriodLabel();
            }
            return;
        }
        
        $criteria = new CDbCriteria;
        $criteria->compare('fret_finv_type',$model_fixr->fixrFiit->fiitFinv->finv_type);
        $criteria->compare('fret_controller_action',$this->id.'/'.$this->action->id);
        $criteria->addCondition("CONCAT(',',fret_period_fret_id_list,',') LIKE '%,".$model_fixr->fixr_position_fret_id.",%'");        
        $criteria->order = 'fret_label';
        $model_fret = FretRefType::model()->findAll($criteria);
        
        $cs = Yii::app()->clientScript;
        $cs->reset();        
        $cs->scriptMap = array(
            'jquery.js' => false, // prevent produce jquery.js in additional javascript data
            'jquery.min.js' => false,
        );        
        
        $this->renderPartial(
                'uiDialogPperiodForm', 
                array(
                    'model_fixr' => $model_fixr,
                    'model_fret' => $model_fret,
                ),
                false,
                true
                );

    }    

    
    /**
     * Service Subform & Save
     * @param type $fret_id
     * @param type $fixr_id
     */
    public function actionShowPositionSubForm($fret_id,$fixr_id){

        if(empty($fret_id)){
            return;
        }

        //get model form detqails
        $model_fret = FretRefType::model()->findByPk($fret_id);
        $form_model_name = $model_fret->fret_model;
        $form_model_ref_field = $model_fret->getRefIdFIeldName();        
        
        //search model form record
        $model_fixr = FixrFiitXRef::model()->findByPk($fixr_id);        
        
        $criteria = new CDbCriteria();
        $criteria->compare($model_fret->fret_model_fixr_id_field, $fixr_id);
        $form_model = new $form_model_name;
        $form_model = $form_model->find($criteria);
        if(!$form_model){
            $form_model = new $form_model_name;
        }
        
        //submited form
        if (isset($_POST[$form_model_name])) {
            if(!$model_fixr){
                return false;
            }

            if($model_fret->fret_controller_action == 'FixrFiitXRef/popupPosition'){
                $model_fixr->fixr_position_fret_id = $fret_id;
            }  else {
                $model_fixr->fixr_period_fret_id = $fret_id;            
            }
            if(!$model_fixr->save()){
                 print_r($model_fixr->getErrors());exit;
            }

            $form_model->scenario = $this->scenario;
            $post = Yii::app()->request->getPost($form_model_name);
            $form_model_pk_name = $form_model->tableSchema->primaryKey;
            if(isset($post[$form_model_pk_name])){
                $form_model_pk_value = $post[$form_model_pk_name];
                $form_model = $form_model->findByPk($form_model_pk_value);
            }

            $form_model->attributes = $_POST[$form_model_name];;
            $form_model->$form_model_ref_field = $fixr_id;            

            try {
                if($form_model->save()){
                    //if period, do postion save() for full calculation
                    if($model_fret->fret_controller_action != 'FixrFiitXRef/popupPosition'){
                        $model_fixr->afterSaveUpdateRelatedModels();
                    }                        
                    echo 'ok';          
                    return;
                }
            } catch (Exception $e) {
                $form_model->addError($form_model->tableSchema->primaryKey, $e->getMessage());
            }
         
        }

        //show form
        $cs = Yii::app()->clientScript;
        $cs->reset();        
        $cs->scriptMap = array(
            'jquery.js' => false, // prevent produce jquery.js in additional javascript data
            'jquery.min.js' => false,
        );     
        
        echo $this->renderPartial(
                '/subform/'.$model_fret->fret_view_form, 
                array(
                    'model' => $form_model,
                    'fixr_id' => $fixr_id,
                    'fret_id' => $fret_id,
                ),
                true,
                true);        
    }
    
    public function actionView($fixr_id, $ajax = false)
    {
        $model = $this->loadModel($fixr_id);
        if($ajax){
            $this->renderPartial('_view-relations_grids', 
                    array(
                        'modelMain' => $model,
                        'ajax' => $ajax,
                        )
                    );
        }else{
            $this->render('view', array('model' => $model,));
        }
    }

    public function actionViewFinv($finv_id, $ajax = false)
    {
        

        if($ajax){
            $a = explode('-',$ajax);
            $model = new FixrFiitXRef();
            $model->fixr_fiit_id = end($a);
            $this->renderPartial('_fixr_grid', 
                    array(
                        'model' => $model,
                        'sub_grid_id' => $ajax,
                        )
                    );
            return;
        }
        $model = FinvInvoice::model()->findByPk($finv_id);        
        $this->render('viewFinv', array('model' => $model,));
        

    }



    public function actionEditableSaver()
    {
        $es = new EditableSaver('FixrFiitXRef'); // classname of model to be updated
        $es->update();
        
        $fixr_id = yii::app()->request->getParam('pk');
        $field_name = yii::app()->request->getParam('name');
        if($field_name == 'fixr_amt'){
            $fixr = FixrFiitXRef::model()->findByPk($fixr_id)->afterSaveUpdateRelatedModels();
        }
        
    }

    /**
     * create fixr record
     * @param string $field value "fixr_fiit_id"
     * @param int $value fiit_id
     * @return boolean
     * @throws CHttpException
     */
    public function actionAjaxCreate($field, $value) 
    {

        //create fixr record
        $model = new FixrFiitXRef;
        $model->addRecord($value);

    }
    
    public function actionDelete($fixr_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $model_fixr = $this->loadModel($fixr_id);
                $model_fixr->delete();
            } catch (Exception $e) {
                throw new CHttpException(500, $e->getMessage());
            }

            if (!isset($_GET['ajax'])) {
                if (isset($_GET['returnUrl'])) {
                    $this->redirect($_GET['returnUrl']);
                } else {
                    $this->redirect(array('admin'));
                }
            }
        } else {
            throw new CHttpException(400, Yii::t('D2fixrModule.crud', 'Invalid request. Please do not repeat this request again.'));
        }
    }

    public function actionFinvInvoice()
    {
        $this->menu_route = 'd2fixr/FixrFiitXRef/FinvInvoice';
        $model = new FinvInvoice('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['FinvInvoice'])) {
            $model->attributes = $_GET['FinvInvoice'];
        }

        $this->render('adminFinv', array('model' => $model,));
    }    
    
    public function actionAdmin()
    {
        $model = new FixrFiitXRef('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['FixrFiitXRef'])) {
            $model->attributes = $_GET['FixrFiitXRef'];
        }

        $this->render('admin', array('model' => $model,));
    }

    public function loadModel($id)
    {
        $m = FixrFiitXRef::model();
        // apply scope, if available
        $scopes = $m->scopes();
        if (isset($scopes[$this->scope])) {
            $m->{$this->scope}();
        }
        $model = $m->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('D2fixrModule.crud', 'The requested page does not exist.'));
        }
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'fixr-fiit-xref-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
