<?php


class ReportController extends Controller
{
    #public $layout='//layouts/column2';

    public $defaultAction = "level1";
    public $scenario = "crud";
    public $scope = "crud";
    public $menu_route = "d2fixr/Report";       


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
            'actions' => array('level1','level2','level3'
                ,'level1transactions','level2transactions','level3transactions'),
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
    public function actionLevel1($year = false)
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
        
        //table
        $table = FddpDimDataPeriod::createTable($months,$positions,$data);
        
        //totals
        $totals = FddpDimDataPeriod::calcTotoals($table);
       
        
        $this->render('level1', array(
            'year' => $year,
            'months' => $months,
            'positions' => $positions,
            'table' => $table,
            'rows_totals' => $totals['row'],
            'columns_totals' => $totals['column'],
            'total' => $totals['total'],
            ));
    }

    /**
     * 
     * @param type $year
     * @todo jāpieliek $year kontrole
     */
    public function actionLevel2($year,$fdm1_id)
    {
        
        //dates
        $months = FdpeDimPeriod::getYearMonths($year);
        
        //main positions
        $positions = Fdm2Dimension2::getPositions($year,$fdm1_id);
        
        //body
        $data = FddpDimDataPeriod::getDataLevelDim2($year,$fdm1_id);
        
        //table
        $table = FddpDimDataPeriod::createTable($months,$positions,$data);
        
        //totals
        $totals = FddpDimDataPeriod::calcTotoals($table);
       
        
        $this->render('level2', array(
            'year' => $year,
            'fdm1_id' => $fdm1_id,
            'months' => $months,
            'positions' => $positions,
            'table' => $table,
            'rows_totals' => $totals['row'],
            'columns_totals' => $totals['column'],
            'total' => $totals['total'],
            ));
    }

    public function actionLevel3($year,$fdm1_id,$fdm2_id)
    {
        
        //dates
        $months = FdpeDimPeriod::getYearMonths($year);
        
        //main positions
        $positions = Fdm3Dimension3::getPositions($year,$fdm2_id);
        
        //body
        $data = FddpDimDataPeriod::getDataLevelDim3($year,$fdm2_id);
        
        //table
        $table = FddpDimDataPeriod::createTable($months,$positions,$data);

        //totals
        $totals = FddpDimDataPeriod::calcTotoals($table);
       
        
        $this->render('level3', array(
            'year' => $year,
            'fdm1_id' => $fdm1_id,
            'fdm2_id' => $fdm2_id,            
            'months' => $months,
            'positions' => $positions,
            'table' => $table,
            'rows_totals' => $totals['row'],
            'columns_totals' => $totals['column'],
            'total' => $totals['total'],
            ));
    }

    /**
     * level 1 month transactions
     * @param type $fdm1_id
     * @param type $year
     * @param type $month
     */
    public function actionLevel1transactions($fdm1_id,$year,$month){
        
        $fdpe_id = FdpeDimPeriod::getIdByYearMonth($year,$month);
        $data = FdpeDimPeriod::getDimMonthPositions($fdpe_id,$fdm1_id);

        $fdm1 = Fdm1Dimension1::model()->findByPk($fdm1_id);
        
        $this->renderPartial('transactions', array(
            'year' => $year,
            'month' => $month,
            'label' => $fdm1->fdm1_name,
            'data' => $data,
            ));        
        
    }

    /**
     * level 1 month transactions
     * @param type $fdm1_id
     * @param type $year
     * @param type $month
     */
    public function actionLevel2transactions($fdm2_id,$year,$month){
        
        $fdpe_id = FdpeDimPeriod::getIdByYearMonth($year,$month);
        $data = FdpeDimPeriod::getDimMonthPositions($fdpe_id,false,$fdm2_id);

        $fdm2 = Fdm2Dimension2::model()->findByPk($fdm2_id);
        
        $this->renderPartial('transactions', array(
            'year' => $year,
            'month' => $month,
            'label' => $fdm2->fdm2_name,
            'data' => $data,
            ));        
        
    }

    /**
     * level 1 month transactions
     * @param type $fdm1_id
     * @param type $year
     * @param type $month
     */
    public function actionLevel3transactions($fdm3_id,$year,$month){
        
        $fdpe_id = FdpeDimPeriod::getIdByYearMonth($year,$month);
        $data = FdpeDimPeriod::getDimMonthPositions($fdpe_id,false,false,$fdm3_id);

        $fdm3 = Fdm3Dimension3::model()->findByPk($fdm3_id);
        
        $this->renderPartial('transactions', array(
            'year' => $year,
            'month' => $month,
            'label' => $fdm3->fdm3_name,
            'data' => $data,
            ));        
        
    }
    
}
