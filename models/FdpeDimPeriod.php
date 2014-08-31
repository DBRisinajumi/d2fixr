<?php

// auto-loading
Yii::setPathOfAlias('FdpeDimPeriod', dirname(__FILE__));
Yii::import('FdpeDimPeriod.*');

class FdpeDimPeriod extends BaseFdpeDimPeriod
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
    
    public static function splitAmtInPeriods($amt, $dt_from, $dt_to,$period_type)
    {
        /**
         * iterate to next period while helper date is still older or the same as end date
         */
        $periods = array();
        $total_period_amt = 0;
        $periods_seconds = 0;

        /**
         * split in periods
         */
        while ($period_data = self::getPeriodLengthData($dt_from, $dt_to,$period_type)) {
            $periods_seconds += $period_data['in_period_sec'];

            $periods[] = array(
                'period_id' => $period_data['id'],
                'in_period_sec' => $period_data['in_period_sec']
            );

            $dt_from = $period_data['date_to'];
            
            $d_date_from = new DateTime($dt_from);
            $d_date_to = new DateTime($dt_to);
            if ($d_date_from == $d_date_to) {
                break;
            }
        }

        /**
         * calc amt for each period
         */
        foreach ($periods as $kP => $aPeriod) {
            if ($periods_seconds == 0) {
                // start date and end date equal
                $nK = 1;
            } else {
                $nK = $aPeriod['in_period_sec']/$periods_seconds;
            }
            $nPeriodAmt = floor($amt * $nK);
            $periods[$kP]['period_amt'] = $nPeriodAmt;
            $total_period_amt += $nPeriodAmt;
        }

        /**
         * fix amt
         */
        if ($amt != $total_period_amt && count($periods) > 0) {
            $nLastPeriodKey = count($periods) - 1;
            $periods[$nLastPeriodKey]['period_amt'] += $amt - $total_period_amt;
        }

        return $periods;
    }
    
    
    public static function getPeriodLengthDataFromDb($date_time_from,$date_time_to,$period_type){
        $sql = "SET @date_from = STR_TO_DATE('{$date_time_from}', '%Y-%m-%d %H:%i:%s');";
        Yii::app()->db->createCommand($sql)->execute();      
        
        $sql = "SET @date_to = STR_TO_DATE('{$date_time_to}', '%Y-%m-%d %H:%i:%s');";        
        Yii::app()->db->createCommand($sql)->execute();      
        
        $sql = "
        SELECT
          fdpe_id id,
          DATE_FORMAT
          (
          CASE
              WHEN fdpe_dt_to < @date_to 
                THEN fdpe_dt_to 
              ELSE @date_to 
          END, '%Y-%m-%d %H:%i:%s'
          ) date_to,
          TIME_TO_SEC(
            TIMEDIFF(
              CASE
                WHEN fdpe_dt_to < @date_to
                THEN fdpe_dt_to
                ELSE @date_to
              END,
              @date_from
            )
          )  in_period_sec
        FROM
          fdpe_dim_period
        WHERE fdpe_type = '{$period_type}'
          AND fdpe_dt_from <= @date_from
          AND fdpe_dt_to > @date_from
        ORDER BY fdpe_dt_from
        LIMIT 1
        ";
        return Yii::app()->db->createCommand($sql)->queryRow();
        
    }
    public static function getPeriodLengthData($date_time_from,$date_time_to,$period_type){
        
        $row = self::getPeriodLengthDataFromDb($date_time_from,$date_time_to,$period_type);
        if (empty($row)) {

            self::createPeriod($date_time_from, $date_time_to,$period_type);
            $row = self::getPeriodLengthDataFromDb($date_time_from,$date_time_to,$period_type);            
        }

        return $row;
        
    }
    
    private static function createPeriod($date_time_from, $date_time_to,$period_type)
    {
        //create period
        $date = new DateTime($date_time_from);
//        $this->current_period->jumpToPeriodStart($date);
//        $sPeriodFrom = $date->format("Y-m-d H:i:s");

        $sPeriodFrom = $date->modify('first day of this month')->format("Y-m-d H:i:s");
        
//        $this->current_period->jumpToNextPeriod($date);
//        $sPeriodTo = $date->format("Y-m-d H:i:s");        
        $sPeriodTo = $date->modify('first day of next month')->format("Y-m-d H:i:s");

        
        $sql = "INSERT INTO `fdpe_dim_period`
                (
                        `fdpe_type`,
                        `fdpe_dt_from`,
                        `fdpe_dt_to`
                )VALUES(
                    '$period_type',
                    '$sPeriodFrom',
                    '$sPeriodTo'
                )";
        
        Yii::app()->db->createCommand($sql)->execute();  
        
        return;
    }
    
    /**
     * Add and update  dim data period
     * @param model $fdda dim data model
     * @param type $period_type
     * @return boolean
     */
    public static function savePeriodData($fdda, $period_type) {

        //get old data
        $sql = "select * from fddp_dim_data_period where fddp_fdda_id = {$fdda->fdda_id}";
        $fddp_records = Yii::app()->db->createCommand($sql)->queryAll();
        $fddp = array();
        foreach ($fddp_records as $key => $fddp_row) {
            $fddp[$fddp_row['fddp_fdpe_id']] = $fddp_row;
        }

        // get new data
        $periods = self::splitAmtInPeriods($fdda->fdda_amt, $fdda->fdda_date_from, $fdda->fdda_date_to, $period_type);
        
        //udate or insert records
        foreach ($periods as $kp => $period) {

            if (isset($fddp[$period['period_id']])) {
                //update
                $sql = "UPDATE `fddp_dim_data_period`
                        SET
                            fddp_amt = {$period['period_amt']},
                            fddp_fixr_id = {$fdda->fdda_fixr_id},
                            fddp_fret_id = {$fdda->fdda_fret_id},
                            fddp_fdm1_id = {$fdda->fdda_fdm1_id},
                            fddp_fdm2_id = {$fdda->fdda_fdm2_id},
                            fddp_fdm3_id = {$fdda->fdda_fdm3_id}
                        WHERE
                            fddp_id = {$fddp[$period['period_id']]['fddp_id']}
                        ";        
                            
                Yii::app()->db->createCommand($sql)->query();
                
                unset($periods[$kp]);
                continue;
            } else {
                //insert
                $sql = "INSERT INTO `fddp_dim_data_period`
                        (
                            `fddp_fdda_id`, `fddp_fdpe_id`, `fddp_amt`, 
                            `fddp_fixr_id`,fddp_fret_id,fddp_fdm2_id,
                            fddp_fdm3_id
                        )
                        VALUES
                        (
                            {$fdda->fdda_id},{$period['period_id']},{$period['period_amt']},
                            {$fdda->fdda_fixr_id},{$fdda->fdda_fret_id},{$fdda->fdda_fdm2_id},
                            {$fdda->fdda_fdm3_id}
                        )";
                Yii::app()->db->createCommand($sql)->query();
                unset($periods[$kp]);
                continue;
            }
        }
        //delete old records
        foreach($periods as $period){
            $sql = "DELETE FROM `fddp_dim_data_period`
                    SET
                        fddp_amt = {$period['period_amt']},
                        fddp_fixr_id = {$fdda->fdda_fixr_id},
                        fddp_fret_id = {$fdda->fdda_fret_id},
                        fddp_fdm2_id = {$fdda->fdda_fdm2_id},
                        fddp_fdm3_id = {$fdda->fdda_fdm3_id}
                    WHERE
                        fddp_id = {$fddp[$period['period_id']]['']}
                    ";        

            Yii::app()->db->createCommand($sql)->query();            
        }
        

        return true;
    }

}