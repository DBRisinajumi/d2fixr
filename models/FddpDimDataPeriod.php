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
              fddp_fdm1_id,
              fddp_fdpe_id,
              SUM(fddp_amt) amt 
            FROM
              fddp_dim_data_period 
              INNER JOIN fdpe_dim_period 
                ON fddp_fdpe_id = fdpe_id 
            WHERE fdpe_dt_from > '{$year}.01.01' 
              AND fdpe_dt_from < '{$next_year}.01.01' 
            GROUP BY fddp_fdm1_id,
              fddp_fdpe_id 
            ORDER BY fddp_fdm1_id,
              fdpe_dt_from 
               ";
        $d = Yii::app()->db->createCommand($sql)->queryAll();
        $data = array();
        foreach($d as $r){
            $key = $r['fddp_fdm1_id'] . '-' . $r['fddp_fdpe_id'];
            if(!isset($data[$r['fddp_fdm1_id']][$r['fddp_fdpe_id']])){
                $data[$r['fddp_fdm1_id']][$r['fddp_fdpe_id']] = 0;
            }
            
            $data[$r['fddp_fdm1_id']][$r['fddp_fdpe_id']] += $r['amt'];
        }
        return $data;
    }       
    
    public static function createTable($months,$positions,$data){
        $table = array();
        foreach($positions as $p){
            foreach ($months as $m){
                if(isset($data[$p['fdm1_id']][$m['fdpe_id']])){
                    $table[$p['fdm1_id']][$m['month']] = self::formatAmt($data[$p['fdm1_id']][$m['fdpe_id']]);
                }else{
                    $table[$p['fdm1_id']][$m['month']] = self::formatAmt(0);
                }
            }
        }
        
        return $table;
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
            return number_format($nAmt/100, 2, '.', '');
        }
        return number_format($nAmt/100, 2, '.', ' ');
    }    
    
}
