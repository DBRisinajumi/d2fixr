<?php


class FpedPeriodDateController extends Controller
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
            'actions' => array('popupServices', 'admin', 'view', 'update', 'editableSaver', 'delete','ajaxCreate'),
            'roles' => array('D2finv.FpedPeriodDate.*'),
        ),
        array(
            'allow',
            'actions' => array('createPopup','ajaxCreate'),
            'roles' => array('D2finv.FpedPeriodDate.Create'),
        ),
        array(
            'allow',
            'actions' => array('view', 'admin'), // let the user view the grid
            'roles' => array('D2finv.FpedPeriodDate.View'),
        ),
        array(
            'allow',
            'actions' => array('update', 'editableSaver'),
            'roles' => array('D2finv.FpedPeriodDate.Update'),
        ),
        array(
            'allow',
            'actions' => array('delete'),
            'roles' => array('D2finv.FpedPeriodDate.Delete'),
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

    public function actionView($fped_id, $ajax = false)
    {
        $model = $this->loadModel($fped_id);
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

    public function actionCreate()
    {
        $model = new FpedPeriodDate;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'fped-period-date-form');

        if (isset($_POST['FpedPeriodDate'])) {
            $model->attributes = $_POST['FpedPeriodDate'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'fped_id' => $model->fped_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('fped_id', $e->getMessage());
            }
        } elseif (isset($_GET['FpedPeriodDate'])) {
            $model->attributes = $_GET['FpedPeriodDate'];
        }

        $this->render('create', array('model' => $model));
    }

    public function actionPopupPeriods($fixr_id)
    {
        $model = new FpedPeriodDate;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'fped-period-date-form');

        if (isset($_POST['FpedPeriodDate'])) {
            $model->attributes = $_POST['FpedPeriodDate'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'fped_id' => $model->fped_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('fped_id', $e->getMessage());
            }
        } elseif (isset($_GET['FpedPeriodDate'])) {
            $model->attributes = $_GET['FpedPeriodDate'];
        }
        echo $this->renderPartial('formPopup', array('model' => $model),true,true);
    }
    
    /**
     * 
     * @param type $fixr_id
     * @todo jāpārnes uz citu kontrolieri (laikam popupFixr tjipa)
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
        
        
        echo $this->renderPartial(
                'popupServices', 
                array(
                    'model_fixr' => $model_fixr,
                    'model_form' => $model_form
                ),
                true,
                true);
    }

    public function actionUpdate($fped_id)
    {
        $model = $this->loadModel($fped_id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'fped-period-date-form');

        if (isset($_POST['FpedPeriodDate'])) {
            $model->attributes = $_POST['FpedPeriodDate'];


            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'fped_id' => $model->fped_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('fped_id', $e->getMessage());
            }
        }

        $this->render('update', array('model' => $model,));
    }

    public function actionEditableSaver()
    {
        Yii::import('TbEditableSaver');
        $es = new TbEditableSaver('FpedPeriodDate'); // classname of model to be updated
        $es->update();
    }

    public function actionAjaxCreate($field, $value) 
    {
        $model = new FpedPeriodDate;
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
    
    public function actionDelete($fped_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($fped_id)->delete();
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
            throw new CHttpException(400, Yii::t('D2finvModule.crud', 'Invalid request. Please do not repeat this request again.'));
        }
    }

    public function actionAdmin()
    {
        $model = new FpedPeriodDate('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['FpedPeriodDate'])) {
            $model->attributes = $_GET['FpedPeriodDate'];
        }

        $this->render('admin', array('model' => $model,));
    }

    public function loadModel($id)
    {
        $m = FpedPeriodDate::model();
        // apply scope, if available
        $scopes = $m->scopes();
        if (isset($scopes[$this->scope])) {
            $m->{$this->scope}();
        }
        $model = $m->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('D2finvModule.crud', 'The requested page does not exist.'));
        }
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'fped-period-date-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
