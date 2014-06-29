<?php


class FixrFiitXRefController extends Controller
{
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";


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
            'actions' => array('popupServices','ShowSubForm','saveSubForm','create', 'admin', 'view', 'update', 'editableSaver', 'delete','ajaxCreate','viewFinv'),
            'roles' => array('D2finv.FixrFiitXRef.*'),
        ),
        array(
            'allow',
            'actions' => array('create','ajaxCreate'),
            'roles' => array('D2finv.FixrFiitXRef.Create'),
        ),
        array(
            'allow',
            'actions' => array('view', 'admin','FixrFiitXRef'), // let the user view the grid
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
    public function actionPopupServices($fixr_id)
    {

        $model_fixr = FixrFiitXRef::model()->findByPk($fixr_id);
        $model_form = false;
        
        /**
         * atrod formas modeli un inicializē
         * @todo jāpārtaisa, lai ņem no tabulas fret_ref_type
         */
        switch ($model_fixr->fixr_fret_id){
            case 1: //truck doc
                $model_form = VtdcTruckDoc::model()->find();
                break;
            case 2: //truck service
                break;
            case 3: //trailer service
                break;
            case 4: //trailer doc
                break;
            default:
                break;
        }

        $cs = Yii::app()->clientScript;
        $cs->reset();        
        $cs->scriptMap = array(
            'jquery.js' => false, // prevent produce jquery.js in additional javascript data
            'jquery.min.js' => false,
        );        
        
        echo $this->renderPartial(
                'fancyForm', 
                array(
                    'model_fixr' => $model_fixr,
                    'model_form' => $model_form
                ),
                true,
                true);
    }    

    
    /**
     * Service Subform
     * @param type $fret_id
     * @param type $fixr_id
     */
    public function actionShowSubForm($fret_id,$fixr_id){

        //get model form detqails
        $model_fret = FretRefType::model()->findByPk($fret_id);
        $form_model_ref_field = $model_fret->getRefIdFIeldName();
        $form_model_name = $model_fret->fret_model;
        
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
    public function actionSaveSubForm(){

        if (!isset($_POST)) {
            return false;
        }

        if (!isset($_POST['fixr_id'])) {
            return false;
        }        

        $fixr_id = $_POST['fixr_id'];
        $model_fixr = FixrFiitXRef::model()->findByPk($fixr_id);
        if(!$model_fixr){
            return false;
        }

        //save 
        if (!isset($_POST['fret_id'])) {
            return false;
        }
        $model_fixr->fixr_fret_id = $_POST['fret_id'];
        if(!$model_fixr->save()){
             print_r($model_fixr->getErrors());exit;
        }
        
        //get model form details
        $form_model_ref_field = $model_fixr->fixrFret->getRefIdFIeldName();
        $form_model_name = $model_fixr->fixrFret->fret_model;
        
        //vreate from model
        $model = new $form_model_name;
        $model->scenario = $this->scenario;

        //$this->performAjaxValidation($model, 'fixr-fiit-xref-form');

        if (isset($_POST[$form_model_name])) {
            
            $form_model_pk_name = $model->tableSchema->primaryKey;
            if(isset($_POST[$form_model_name][$form_model_pk_name])){
                $form_model_pk_value = $_POST[$form_model_name][$form_model_pk_name];
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
//        echo $this->renderPartial(
//                '/subform/'.$form_model_name, 
//                array(
//                    'model' => $model,
//                    'model_fixr' => $model_fixr,
//                ),
//                true,
//                true
//            );  
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
        Yii::import('TbEditableSaver');
        $es = new TbEditableSaver('FixrFiitXRef'); // classname of model to be updated
        $es->update();
    }

    public function actionAjaxCreate($field, $value) 
    {
        $model = new FixrFiitXRef;
        $model->$field = $value;
        try {
            if ($model->save()) {
                return TRUE;
            }else{
                return var_export($model->getErrors());
            }            
        } catch (Exception $e) {
            throw new CHttpException(500, $e->getMessage());
        }
    }
    
    public function actionDelete($fixr_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($fixr_id)->delete();
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
