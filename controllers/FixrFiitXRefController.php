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

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        if ($this->module !== null) {
            $this->breadcrumbs[$this->module->Id] = array('/' . $this->module->Id);
        }
        return true;
    }
    
    /**
     * Create popup with service type listbox and ajax loading form
     * render partial for ajax
     * @param int $fixr_id
     */
    public function actionPopupPosition($fixr_id,$get_label = false)
    {

        $model_fixr = FixrFiitXRef::model()->findByPk($fixr_id);
        
        //for ajax get caller label
        if($get_label){
            if($model_fixr){
                echo $model_fixr->getFretLabel();
            }
            return;
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
                echo $model_fixr->getFrepLabel();
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
     * Service Subform
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
        
        //search model form record
        $model_fixr = FixrFiitXRef::model()->findByPk($fixr_id);
        
        $criteria = new CDbCriteria();
        $criteria->compare($model_fret->fret_model_fixr_id_field, $fixr_id);
        $form_model = new $form_model_name;
        $form_model = $form_model->find($criteria);
        if(!$form_model){
            $form_model = new $form_model_name;
        }

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
    /**
     * Service Subform
     * @param type $fret_id
     * @param type $fixr_id
     */
    public function actionShowPeriodSubForm($fret_id,$fixr_id){

        if(empty($fret_id)){
            return;
        }
        
        //get model form detqails
        $model_frep = FrepRefPeriod::model()->findByPk($fret_id);
        $form_model_ref_field = $model_frep->getRefIdFIeldName();
        $form_model_name = $model_frep->frep_model;
        
        //search model form record
        $model_fixr = FixrFiitXRef::model()->findByPk($fixr_id);
        
        $criteria = new CDbCriteria();
        $criteria->compare($form_model_ref_field, $fixr_id);
        $form_model = new $form_model_name;
        $form_model = $form_model->find($criteria);
        
        if(!$form_model){
            $form_model = new $form_model_name;
        }

        echo $this->renderPartial(
                '/subform/'.$form_model_name, 
                array(
                    'model' => $form_model,
                    'fixr_id' => $fixr_id,
                    'fret_id' => $fret_id,
                ),
                true,
                true);        
    }

    /**
     * save fancy box sub form
     * 
     * @return boolean
     * @todo mainot tipu (fret_id), jāizdzēs iepriekšejā tipa ieraksts
     * @todo pēc saglabāšanas automātiski jāaiztaisa Fancy Box
     * @todo pēc saglabāšanas jāmaina labels
     */
    public function actionSavePositionSubForm(){

        $fixr_id = Yii::app()->request->getPost('fixr_id');
        if (empty($fixr_id)) {
            return false;
        }
        
        $model_fixr = FixrFiitXRef::model()->findByPk($fixr_id);
        if(!$model_fixr){
            return false;
        }

        //save 
        $fret_id = Yii::app()->request->getPost('fret_id');        
        if (empty($fret_id)) {
            return false;
        }
        
        $fret = FretRefType::model()->findByPk($fret_id);
        
        if($fret->fret_controller_action == 'FixrFiitXRef/popupPosition'){
            $model_fixr->fixr_position_fret_id = $fret_id;
        }  else {
            $model_fixr->fixr_period_fret_id = $fret_id;            
        }
        if(!$model_fixr->save()){
             print_r($model_fixr->getErrors());exit;
        }
        
        //get model form details
        if($fret->fret_controller_action == 'FixrFiitXRef/popupPosition'){
            $form_model_ref_field = $model_fixr->fixrPositionFret->getRefIdFIeldName();
            $form_model_name = $model_fixr->fixrPositionFret->fret_model;
        } else {
            $form_model_ref_field = $model_fixr->fixrPeriodFret->getRefIdFIeldName();
            $form_model_name = $model_fixr->fixrPeriodFret->fret_model;            
        }
        
        //vreate from model
        $model = new $form_model_name;
        $model->scenario = $this->scenario;

        //$this->performAjaxValidation($model, 'fixr-fiit-xref-form');

        if (isset($_POST[$form_model_name])) {
            
            $post = Yii::app()->request->getPost($form_model_name);
            $form_model_pk_name = $model->tableSchema->primaryKey;
            if(isset($post[$form_model_pk_name])){
                $form_model_pk_value = $post[$form_model_pk_name];
                $model = $model->findByPk($form_model_pk_value);
            }
            
            $model->attributes = $_POST[$form_model_name];;
            $model->$form_model_ref_field = $fixr_id;            

            try {
                if(!$model->save()){
                    print_r($model->getErrors());exit;
                }
            } catch (Exception $e) {
                $model->addError($model->tableSchema->primaryKey, $e->getMessage());
            }
        } 

    }
    /**
     * save fancy box sub form
     * 
     * @return boolean
     * @todo mainot tipu (fret_id), jāizdzēs iepriekšejā tipa ieraksts
     * @todo pēc saglabāšanas automātiski jāaiztaisa Fancy Box
     * @todo pēc saglabāšanas jāmaina labels
     */
    public function actionSavePeriodSubForm(){

        $fixr_id = Yii::app()->request->getPost('fixr_id');
        if(empty($fixr_id)){
            return false;
        }

        $model_fixr = FixrFiitXRef::model()->findByPk($fixr_id);
        if(!$model_fixr){
            return false;
        }

        //save 
        $frep_id = Yii::app()->request->getPost('frep_id');
        if(empty($frep_id)){
            return false;
        }        
        $model_fixr->fixr_period_fret_id = $frep_id;
        if(!$model_fixr->save()){
             print_r($model_fixr->getErrors());exit;
        }
        
        //get model form details
        $form_model_ref_field = $model_fixr->fixrPeriodFret->getRefIdFIeldName();
        $form_model_name = $model_fixr->fixrPeriodFret->frep_model;
        
        //vreate from model
        $model = new $form_model_name;
        $model->scenario = $this->scenario;

        //$this->performAjaxValidation($model, 'fixr-fiit-xref-form');

        if (isset($_POST[$form_model_name])) {
            $post = Yii::app()->request->getPost($form_model_name);
            $form_model_pk_name = $model->tableSchema->primaryKey;
            if(isset($post[$form_model_pk_name])){
                $form_model_pk_value = $post[$form_model_pk_name];
                $model = $model->findByPk($form_model_pk_value);
            }
            
            $model->attributes = $_POST[$form_model_name];
            $model->$form_model_ref_field = $fixr_id;            

            try {
                if(!$model->save()){
                    print_r($model->getErrors());exit;
                }
            } catch (Exception $e) {
                $model->addError($model->tableSchema->primaryKey, $e->getMessage());
            }
        } 
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

    public function actionCreate()
    {
        $model = new FixrFiitXRef;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'fixr-fiit-xref-form');

        if (isset($_POST['FixrFiitXRef'])) {
            $model->attributes = $_POST['FixrFiitXRef'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'fixr_id' => $model->fixr_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('fixr_id', $e->getMessage());
            }
        } elseif (isset($_GET['FixrFiitXRef'])) {
            $model->attributes = $_GET['FixrFiitXRef'];
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($fixr_id)
    {
        $model = $this->loadModel($fixr_id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'fixr-fiit-xref-form');

        if (isset($_POST['FixrFiitXRef'])) {
            $model->attributes = $_POST['FixrFiitXRef'];


            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'fixr_id' => $model->fixr_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('fixr_id', $e->getMessage());
            }
        }

        $this->render('update', array('model' => $model,));
    }

    public function actionEditableSaver()
    {
        $es = new EditableSaver('FixrFiitXRef'); // classname of model to be updated
        $es->update();
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
