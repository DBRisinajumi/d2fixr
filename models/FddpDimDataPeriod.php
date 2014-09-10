<?php

// auto-loading
Yii::setPathOfAlias('FddpDimDataPeriod', dirname(__FILE__));
Yii::import('FddpDimDataPeriod.*');

class FddpDimDataPeriod extends BaseFddpDimDataPeriod
{

    // Add your model-specific methods here. This file will not be overriden by gtc except you force it.
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function init()
    {
        return parent::init();
    }

    public function getItemLabel()
    {
        return parent::getItemLabel();
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            array()
        );
    }

    public function rules()
    {
        return array_merge(
            parent::rules()
        /* , array(
          array('column1, column2', 'rule1'),
          array('column3', 'rule2'),
          ) */
        );
    }

    public function search($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $this->searchCriteria($criteria),
        ));
    }

    public static function getDataLevelDim1($year){
        $next_year = $year + 1;
        $sql = " 
            SELECT 
              fddp_fdm1_id row_id,
              fddp_fdpe_id,
              SUM(fddp_amt) amt 
            FROM
              fddp_dim_data_period 
              INNER JOIN fdpe_dim_period 
                ON fddp_fdpe_id = fdpe_id 
            WHERE fdpe_dt_from >= '{$year}.01.01' 
              AND fdpe_dt_from < '{$next_year}.01.01' 
              AND fddp_sys_ccmp_id = ".Yii::app()->sysCompany->getActiveCompany()."        
            GROUP BY fddp_fdm1_id,
              fddp_fdpe_id 
            ORDER BY fddp_fdm1_id,
              fdpe_dt_from 
               ";
        $d = Yii::app()->db->createCommand($sql)->queryAll();
        $data = array();
        foreach($d as $r){
            if(!isset($data[$r['row_id']][$r['fddp_fdpe_id']])){
                $data[$r['row_id']][$r['fddp_fdpe_id']] = 0;
            }
            
            $data[$r['row_id']][$r['fddp_fdpe_id']] += $r['amt'];
        }
        return $data;
    }       
    
    public static function getDataLevelDim2($year,$fddp_fdm1_id){
        $next_year = $year + 1;
        $sql = " 
            SELECT 
              fddp_fdm2_id row_id,
              fddp_fdpe_id,
              SUM(fddp_amt) amt 
            FROM
              fddp_dim_data_period 
              INNER JOIN fdpe_dim_period 
                ON fddp_fdpe_id = fdpe_id 
            WHERE fdpe_dt_from >= '{$year}.01.01' 
              AND fdpe_dt_from < '{$next_year}.01.01' 
              AND fddp_fdm1_id = {$fddp_fdm1_id}
              AND fddp_sys_ccmp_id = ".Yii::app()->sysCompany->getActiveCompany()."    
            GROUP BY fddp_fdm2_id,
              fddp_fdpe_id 
            ORDER BY fddp_fdm2_id,
              fdpe_dt_from 
               ";
        $d = Yii::app()->db->createCommand($sql)->queryAll();
        $data = array();
        foreach($d as $r){
            if(!isset($data[$r['row_id']][$r['fddp_fdpe_id']])){
                $data[$r['row_id']][$r['fddp_fdpe_id']] = 0;
            }
            
            $data[$r['row_id']][$r['fddp_fdpe_id']] += $r['amt'];
        }
        return $data;
    }       

    public static function getDataLevelDim3($year,$fddp_fdm2_id){
        
        $next_year = $year + 1;
        
        $sql = " 
            SELECT 
                case 
                    when fddp_fdst_id is null 
                        then fddp_fdm3_id
                    when fddp_fdst_ref_id is null 
                        then concat(fddp_fdm3_id,'-',fddp_fdst_id)
                    else    
                        concat(fddp_fdm3_id,'-',fddp_fdst_id,'-',fddp_fdst_ref_id)
                    end row_id,
              fddp_fdpe_id,
              SUM(
                CASE fddp_cd
                    WHEN 'C' THEN fddp_amt
                    ELSE -fddp_amt
                END
                ) amt
            FROM
              fddp_dim_data_period 
              INNER JOIN fdpe_dim_period 
                ON fddp_fdpe_id = fdpe_id 
            WHERE fdpe_dt_from >= '{$year}.01.01' 
              AND fdpe_dt_from < '{$next_year}.01.01' 
              AND fddp_fdm2_id = {$fddp_fdm2_id}
              AND fddp_sys_ccmp_id = ".Yii::app()->sysCompany->getActiveCompany()."        
            GROUP BY fddp_fdm3_id,
              fddp_fdpe_id,
              fddp_fdst_id,
              fddp_fdst_ref_id
            ORDER BY fddp_fdm3_id,
              fdpe_dt_from 
               ";
        $d = Yii::app()->db->createCommand($sql)->queryAll();

        $data = array();
        foreach($d as $r){
            if(!isset($data[$r['row_id']][$r['fddp_fdpe_id']])){
                $data[$r['row_id']][$r['fddp_fdpe_id']] = 0;
            }
            
            $data[$r['row_id']][$r['fddp_fdpe_id']] += $r['amt'];
        }
        return $data;
    }       
    
    public static function createTable($months,$positions,$data){
        $table = array();
        foreach($positions as $p){
            foreach ($months as $m){
                if(isset($data[$p['row_id']][$m['fdpe_id']])){
                    $table[$p['row_id']][$m['month']] = self::formatAmtFromInt($data[$p['row_id']][$m['fdpe_id']]);
                }else{
                    $table[$p['row_id']][$m['month']] = self::formatAmtFromInt(0);
                }
            }
        }
        
        return $table;
    }
    
    public static function calcTotoals($table){
        
        $r_total = array();
        $c_total = array();
        $total = 0;
        foreach ($table as $k_row => $row){
            $r_total[$k_row] = 0;
            $row_total = 0;
            foreach ($row as $k_column => $cell){
                $row_total += $cell;
                if(!isset($c_total[$k_column])){
                    $c_total[$k_column] = 0;
                }
                $c_total[$k_column] += $cell;
            }
            $r_total[$k_row] = self::formatAmt($row_total);
            $total += $row_total;
        }
        
        foreach($c_total as $k => $v){
            $c_total[$k] = self::formatAmt($v);
        }
        
        return array(
            'row' => $r_total, 
            'column' => $c_total,
            'total' => $total,
            );
        
    }
    
    
    /**
     * get formatted amount of money
     * 
     * @assert (0) == '0.00'
     * @param int $nAmt
     * @return string
     */
    public static function formatAmtFromInt($nAmt,$bForExcel = FALSE)
    {
        //money_format() ?
        if($bForExcel){
            return number_format($nAmt/100, 2, '.', '');
        }
        return number_format($nAmt/100, 2, '.', ' ');
    }    

    /**
     * get formatted amount of money
     * 
     * @assert (0) == '0.00'
     * @param int $nAmt
     * @return string
     */
    public static function formatAmt($nAmt,$bForExcel = FALSE)
    {
        //money_format() ?
        if($bForExcel){
            return number_format($nAmt, 2, '.', '');
        }
        return number_format($nAmt, 2, '.', ' ');
    }    
    
}
