<?php


class Fdm3Dimension3Controller extends Controller
{
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";
    public $menu_route = "d2fixr/fdm1Dimension1";

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
                'roles' => array('D2fixr.Fdm3Dimension3.*'),
            ),
            array(
                'allow',
                'actions' => array('create','ajaxCreate'),
                'roles' => array('D2fixr.Fdm3Dimension3.Create'),
            ),
            array(
                'allow',
                'actions' => array('view', 'admin'), // let the user view the grid
                'roles' => array('D2fixr.Fdm3Dimension3.View'),
            ),
            array(
                'allow',
                'actions' => array('update', 'editableSaver'),
                'roles' => array('D2fixr.Fdm3Dimension3.Update'),
            ),
            array(
                'allow',
                'actions' => array('delete'),
                'roles' => array('D2fixr.Fdm3Dimension3.Delete'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionView($fdm3_id, $ajax = false)
    {
        $model = $this->loadModel($fdm3_id);
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

    public function actionCreate($fdm2_id = false)
    {
        $model = new Fdm3Dimension3;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'fdm3-dimension3-form');

        if (isset($_POST['Fdm3Dimension3'])) {
            $model->attributes = $_POST['Fdm3Dimension3'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('admin', 'fdm2_id' => $model->fdm3_fdm2_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('fdm3_id', $e->getMessage());
            }
        } elseif (isset($_GET['Fdm3Dimension3'])) {
            $model->attributes = $_GET['Fdm3Dimension3'];
        }

        if($fdm2_id){
            $model->fdm3_fdm2_id = $fdm2_id;
            $fdm2 = Fdm2Dimension2::model()->findByPk($fdm2_id);
            $model->fdm3_fret_id = $fdm2->fdm2_fret_id;
        }
        
        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($fdm3_id)
    {
        $model = $this->loadModel($fdm3_id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'fdm3-dimension3-form');

        if (isset($_POST['Fdm3Dimension3'])) {
            $model->attributes = $_POST['Fdm3Dimension3'];


            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'fdm3_id' => $model->fdm3_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('fdm3_id', $e->getMessage());
            }
        }

        $this->render('update', array('model' => $model));
    }

    public function actionEditableSaver()
    {
        $es = new EditableSaver('Fdm3Dimension3'); // classname of model to be updated
        $es->update();
    }

    public function actionAjaxCreate($field, $value) 
    {
        $model = new Fdm3Dimension3;
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
    
    public function actionDelete($fdm3_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($fdm3_id)->delete();
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

    public function actionAdmin($fdm2_id)
    {
        $model = new Fdm3Dimension3('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['Fdm3Dimension3'])) {
            $model->attributes = $_GET['Fdm3Dimension3'];
        }
        
        $model->fdm3_fdm2_id = $fdm2_id;
            
        $fdm2 = Fdm2Dimension2::model()->findByPk($fdm2_id);
        $this->render('admin', array(
            'model' => $model,
            'fdm2' => $fdm2,
            ));
    }

    public function loadModel($id)
    {
        $m = Fdm3Dimension3::model();
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'fdm3-dimension3-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
