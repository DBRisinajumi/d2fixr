<?php


class Fdm1Dimension1Controller extends Controller
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
            'actions' => array('create', 'admin',  'editableSaver', 'delete'),
            'roles' => array('D2fixr.Fdm1Dimension1.*'),
        ),
        array(
            'allow',
            'actions' => array('admin'), // let the user view the grid
            'roles' => array('D2fixr.Fdm1Dimension1.View'),
        ),
        array(
            'allow',
            'actions' => array('editableSaver'),
            'roles' => array('D2fixr.Fdm1Dimension1.Update'),
        ),
        array(
            'allow',
            'actions' => array('delete'),
            'roles' => array('D2fixr.Fdm1Dimension1.Delete'),
        ),
        array(
            'deny',
            'users' => array('*'),
        ),
    );
}

    public function actionCreate()
    {
        $model = new Fdm1Dimension1;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'fdm1-dimension1-form');

        if (isset($_POST['Fdm1Dimension1'])) {
            $model->attributes = $_POST['Fdm1Dimension1'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('admin'));
                    }
                }
            } catch (Exception $e) {
                $model->addError('fdm1_id', $e->getMessage());
            }
        } elseif (isset($_GET['Fdm1Dimension1'])) {
            $model->attributes = $_GET['Fdm1Dimension1'];
        }

        $this->render('create', array('model' => $model));
    }

    public function actionEditableSaver()
    {
        $es = new EditableSaver('Fdm1Dimension1'); // classname of model to be updated
        $es->update();
    }

    public function actionDelete($fdm1_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($fdm1_id)->delete();
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
        $model = new Fdm1Dimension1('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['Fdm1Dimension1'])) {
            $model->attributes = $_GET['Fdm1Dimension1'];
        }

        $this->render('admin', array('model' => $model));
    }

    public function loadModel($id)
    {
        $m = Fdm1Dimension1::model();
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'fdm1-dimension1-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}