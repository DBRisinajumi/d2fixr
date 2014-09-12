<?php


class Fdm2Dimension2Controller extends Controller
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
            'actions' => array('create', 'admin', 'view', 'update', 'editableSaver', 'delete','ajaxCreate'),
            'roles' => array('D2fixr.Fdm2Dimension2.*'),
        ),
        array(
            'allow',
            'actions' => array('create','ajaxCreate'),
            'roles' => array('D2fixr.Fdm2Dimension2.Create'),
        ),
        array(
            'allow',
            'actions' => array('view', 'admin'), // let the user view the grid
            'roles' => array('D2fixr.Fdm2Dimension2.View'),
        ),
        array(
            'allow',
            'actions' => array('update', 'editableSaver'),
            'roles' => array('D2fixr.Fdm2Dimension2.Update'),
        ),
        array(
            'allow',
            'actions' => array('delete'),
            'roles' => array('D2fixr.Fdm2Dimension2.Delete'),
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

    public function actionView($fdm2_id, $ajax = false)
    {
        $model = $this->loadModel($fdm2_id);
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

    public function actionCreate($fdm1_id = false)
    {
        $model = new Fdm2Dimension2;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'fdm2-dimension2-form');

        if (isset($_POST['Fdm2Dimension2'])) {
            $model->attributes = $_POST['Fdm2Dimension2'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'fdm2_id' => $model->fdm2_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('fdm2_id', $e->getMessage());
            }
        } elseif (isset($_GET['Fdm2Dimension2'])) {
            $model->attributes = $_GET['Fdm2Dimension2'];
        }
        
        if($fdm1_id){
            $model->fdm2_fdm1_id = $fdm1_id;
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($fdm2_id)
    {
        $model = $this->loadModel($fdm2_id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'fdm2-dimension2-form');

        if (isset($_POST['Fdm2Dimension2'])) {
            $model->attributes = $_POST['Fdm2Dimension2'];


            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'fdm2_id' => $model->fdm2_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('fdm2_id', $e->getMessage());
            }
        }

        $this->render('update', array('model' => $model));
    }

    public function actionEditableSaver()
    {
        $es = new EditableSaver('Fdm2Dimension2'); // classname of model to be updated
        $es->update();
    }

    public function actionAjaxCreate($field, $value) 
    {
        $model = new Fdm2Dimension2;
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
    
    public function actionDelete($fdm2_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($fdm2_id)->delete();
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

    public function actionAdmin($fdm1_id)
    {
        $model = new Fdm2Dimension2('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['Fdm2Dimension2'])) {
            $model->attributes = $_GET['Fdm2Dimension2'];
            $model->fdm2_fdm1_id = $fdm1_id;
        }
        $model->fdm2_fdm1_id = $fdm1_id;
        
        $fdm1 = Fdm1Dimension1::model()->findByPk($fdm1_id);
        
        $this->render('admin', array(
            'model' => $model,
            'fdm1' => $fdm1,
            ));
    }

    public function loadModel($id)
    {
        $m = Fdm2Dimension2::model();
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'fdm2-dimension2-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
