<?php


class ReportController extends Controller
{
    #public $layout='//layouts/column2';

    public $defaultAction = "main";
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
            'actions' => array('main'),
            'roles' => array('D2fixr.report.main'),
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
     * 
     * @param type $year
     * @todo jāpieliek $year kontrole
     */
    public function actionMain($year = false)
    {
        
        if(!$year){
            $year = date('Y');
        }
        
        //dates
        $months = FdpeDimPeriod::getYearMonths($year);
        
        //main positions
        $positions = Fdm1Dimension1::getPositions($year);
        
        //body
        $data = FddpDimDataPeriod::getDataLevelDim1($year);
        //var_dump($data);
        $table = FddpDimDataPeriod::createTable($months,$positions,$data);
        //var_dump($table);exit;
        
        $this->render('main', array(
            'months' => $months,
            'positions' => $positions,
            'table' => $table,
            ));
    }

}
