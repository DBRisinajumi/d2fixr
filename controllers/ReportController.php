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
            'actions' => array('level1','level2','level3'),
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

}
