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
    
    
    /**
     * 
     * @param int $amt  amount in cents
     * @param datetime $dt_from
     * @param datetime $dt_to
     * @param string $period_type only Montly
     * @return array(array('period_id'=>22,'in_period_sec'=>555),...)
     */
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
        $kTotal = 0;
        while ($period_data = self::getPeriodLengthData($dt_from, $dt_to,$period_type)) {
            $periods_seconds += $period_data['in_period_sec'];

            $periods[] = array(
                'period_id' => $period_data['id'],
                'in_period_sec' => $period_data['in_period_sec'],
                'from' => $dt_from,
                'to' => $period_data['date_to'],
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
            $kTotal += $nK;
            $nPeriodAmt = floor($amt * $nK);
            $periods[$kP]['period_amt'] = $nPeriodAmt;
            $periods[$kP]['k'] = $nK;
            $total_period_amt += $nPeriodAmt;
        }

        /**
         * fix amt
         */
        if ($amt != $total_period_amt && count($periods) > 0) {
            $nLastPeriodKey = count($periods) - 1;
            $periods[$nLastPeriodKey]['period_amt'] += $amt - $total_period_amt;
        }
//        var_dump($amt);
//        var_dump($total_period_amt);
//        var_dump($kTotal);
//        var_dump($periods);exit;
        return $periods;
    }
    
    public static function splitPeriodAmtInTypes($periods, $fdda_id) {

        $sys_company = Yii::app()->sysCompany->getActiveCompany();
        $sql = "  
            SELECT 
                vtrc_id,
                vtrc_car_reg_nr 
            FROM 
                vtrc_truck 
            WHERE 
                vtrc_cmmp_id = {$sys_company}
                 ";
        $ref_list = $rows = Yii::app()->db->createCommand($sql)->queryAll();
        
        $sql = "  
            SELECT 
              fdsp_fdst_id,
              fdsp_procenti,
              CASE
                WHEN fdda_fdm3_id = fdsp_fdm3_id 
                THEN 3 
                WHEN fdda_fdm2_id = fdsp_fdm2_id 
                THEN 2 
                WHEN fdda_fdm1_id = fdsp_fdm1_id 
                THEN 1 
              END level              
            FROM
              fdda_dim_data 
              INNER JOIN fdsp_dimension_split 
                ON fdda_fdm1_id = fdsp_fdm1_id and fdsp_fdm2_id is null and fdsp_fdm3_id is null
                OR fdda_fdm2_id = fdsp_fdm2_id and fdsp_fdm3_id is null
                OR fdda_fdm3_id = fdsp_fdm3_id 
            WHERE fdda_id = {$fdda_id}
            ORDER BY 
              CASE
                WHEN fdda_fdm3_id = fdsp_fdm3_id 
                THEN 1 
                WHEN fdda_fdm2_id = fdsp_fdm2_id 
                THEN 2 
                WHEN fdda_fdm1_id = fdsp_fdm1_id 
                THEN 3 
              END 
                 ";

        $rows = Yii::app()->db->createCommand($sql)->queryAll();

        if (empty($rows)) {
            return $periods;
        }
        $new_periods = array();
        $included_amt = 0;
        foreach ($periods as $period) {

            $level = $rows[0]['level'];
            foreach ($rows as $row) {
                if ($level != $row['level']) {
                    break;
                }
                $amt = round($period['period_amt'] * $row['fdsp_procenti']/100);
                $ref_amt = round($amt/count($ref_list));

                foreach ($ref_list as $ref){
                
                    
                $new_period = $period;
                $new_period['fdst_id'] = $row['fdsp_fdst_id'];
                    $new_period['period_amt'] = $ref_amt;
                    $new_period['fddp_fdst_ref_id'] = $ref['vtrc_id'];
                $new_periods[] = $new_period;
                    $included_amt += $ref_amt;
            }
            }
            
            //atlikumu piefikseejam
            $new_period = $period;
            $new_period['period_amt'] = $period['period_amt'] - $included_amt;
            $new_periods[] = $new_period;
            
        }

        return $new_periods;
    }

    /**
     * get period id and time in period
     * @param datetime $date_time_from
     * @param datetime $date_time_to
     * @param string $period_type only montly
     * @return array('id' => 22, 'in_period_sec'=>333)
     */
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
    
    
    /**
     * try get from db period  and length for interval start. If no exist, create it.
     * @param datetime $date_time_from
     * @param datetime $date_time_to
     * @param string $period_type
     * @return array('id' => 22, 'in_period_sec'=>333)
     */
    public static function getPeriodLengthData($date_time_from,$date_time_to,$period_type){
        
        $row = self::getPeriodLengthDataFromDb($date_time_from,$date_time_to,$period_type);
        if (empty($row)) {

            self::createPeriod($date_time_from, $date_time_to,$period_type);
            $row = self::getPeriodLengthDataFromDb($date_time_from,$date_time_to,$period_type);            
        }

        return $row;
        
    }

    /**
     * create first month period for interval
     * @param datetime $date_time_from
     * @param datetime $date_time_to
     * @param string $period_type Only 'Montly' work
     * @return type
     */
    private static function createPeriod($date_time_from, $date_time_to,$period_type)
    {
        //create period
        $date = new DateTime($date_time_from);
        $sPeriodFrom = $date->modify('first day of this month')->format("Y-m-d H:i:s");
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
        $sql = "select 
                * 
                from 
                    fddp_dim_data_period 
                where 
                    fddp_fdda_id = {$fdda->fdda_id}
                    AND  fddp_sys_ccmp_id = ".Yii::app()->sysCompany->getActiveCompany()."
                   ";
        $fddp_records = Yii::app()->db->createCommand($sql)->queryAll();
        $fddp = array();
        foreach ($fddp_records as $key => $fddp_row) {
            $new_key = $fddp_row['fddp_fdpe_id'];
            if(!empty($fddp_row['fddp_fdst_id'])){
                $new_key .= '-' . $fddp_row['fddp_fdst_id'];
            }
            if(!empty($fddp_row['fddp_fdst_ref_id'])){
                $new_key .= '-' . $fddp_row['fddp_fdst_ref_id'];
            }
            $fddp[$new_key] = $fddp_row;
        }

        // get new data
        $periods = self::splitAmtInPeriods($fdda->fdda_amt, $fdda->fdda_date_from, $fdda->fdda_date_to, $period_type);
        
        $periods = self::splitPeriodAmtInTypes($periods, $fdda->fdda_id);
        
        //udate or insert records
        foreach ($periods as $kp => $period) {

            $key = $period['period_id'];
            if(isset($period['fdst_id']) && isset($period['fddp_fdst_ref_id'])){
                $key .= '-' . $period['fdst_id'] . '-' . $period['fddp_fdst_ref_id'];
            }elseif(isset($period['fdst_id'])){
                $key .= '-' . $period['fdst_id'];
                $period['fddp_fdst_ref_id'] = 'null';
            }else{
                $period['fdst_id'] = 'null';
                $period['fddp_fdst_ref_id'] = 'null';
            }

            if (isset($fddp[$key])) {
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
                unset($fddp[$key]);
                continue;
            } else {
                //insert
                $sql = "INSERT INTO `fddp_dim_data_period`
                        (
                            `fddp_fdda_id`, `fddp_fdpe_id`, `fddp_amt`, 
                            `fddp_fixr_id`,fddp_fret_id,fddp_fdm1_id,
                            fddp_fdm2_id,
                            fddp_fdm3_id,fddp_fdst_id,fddp_fdst_ref_id,
							fddp_sys_ccmp_id
                        )
                        VALUES
                        (
                            {$fdda->fdda_id},{$period['period_id']},{$period['period_amt']},
                            {$fdda->fdda_fixr_id},{$fdda->fdda_fret_id},{$fdda->fdda_fdm1_id},
                            {$fdda->fdda_fdm2_id},    
                            {$fdda->fdda_fdm3_id},{$period['fdst_id']},{$period['fddp_fdst_ref_id']}
							,".Yii::app()->sysCompany->getActiveCompany()."
                        )";
                Yii::app()->db->createCommand($sql)->query();
                unset($periods[$kp]);
                continue;
            }
        }
        //delete old records
        foreach($fddp as $row){
            $sql = "DELETE FROM `fddp_dim_data_period`
                    WHERE
                        fddp_id = {$row['fddp_id']}
                    ";        

            Yii::app()->db->createCommand($sql)->query();            
        }
        

        return true;
    }
    
    public static function getYearMonths($year){
        $sql = " 
            SELECT 
                fdpe_id,
                DATE_FORMAT(`fdpe_dt_from`, '%m.%Y') label,
                month(`fdpe_dt_from`) month
            FROM
              fdpe_dim_period 
            WHERE YEAR(fdpe_dt_from) = {$year} 
               ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        
        $months = array();
        foreach($data as $record){
            $months[$record['month']] = $record;
        }
        
        for ($m = 1; $m < 13; $m++) {
            if(!isset($months[$m])){
                $months[$m] = array(
                    'label' => str_pad($m,2,'0',STR_PAD_LEFT).'.'.$year,
                    'fdpe_id' => NULL,
                    'month' => $m, 
                    );
            }
        }
        ksort($months,SORT_NUMERIC);
        return $months;
        
    }

    public static function getIdByYearMonth($year,$month){
        $sql = " 
            SELECT 
                fdpe_id
            FROM
                fdpe_dim_period 
            WHERE 
                fdpe_type = '".FdpeDimPeriod::FDPE_TYPE_MONTLY."'
                and fdpe_dt_from = :date_from
               ";
        
        $rawData = Yii::app()->db->createCommand($sql);
        $month_start_date =  $year.'-'.$month.'-01';
        $rawData->bindParam(":date_from",$month_start_date);      
        return $rawData->queryScalar();
       
    }
    
    public static function getDimMonthPositions($fdpe_id,$fdim1_id = false,$fdim2_id = false,$fdim3_id = false){
        
        $sql = " 
            SELECT 
              --	*
              finv_id,
              finv_number,
              finv_date,
              fiit_desc,
              fixr_base_amt,
              fddp_amt
            FROM
              fddp_dim_data_period 
              INNER JOIN fixr_fiit_x_ref 
                ON fddp_fixr_id = fixr_id 
              INNER JOIN fiit_invoice_item 
                ON fixr_fiit_id = fiit_id 
              INNER JOIN finv_invoice 
                ON fiit_finv_id = finv_id 
            WHERE fddp_fdpe_id = :fdpe_id
              ";
        
        if($fdim1_id){
            $sql .= ' AND fddp_fdm1_id = :fdim1_id';
            $rawData = Yii::app()->db->createCommand($sql);
            $rawData->bindParam(":fdim1_id",$fdim1_id);   
        }elseif($fdim2_id){
            $sql .= ' AND fddp_fdm2_id = :fdim2_id';
            $rawData = Yii::app()->db->createCommand($sql);
            $rawData->bindParam(":fdim2_id",$fdim2_id);   
        }elseif($fdim3_id){
            $sql .= ' AND fddp_fdm3_id = :fdim3_id';
            $rawData = Yii::app()->db->createCommand($sql);
            $rawData->bindParam(":fdim3_id",$fdim3_id);   
        }
        
        $rawData->bindParam(":fdpe_id",$fdpe_id);      
        return $rawData->queryAll();        
        
    }

}