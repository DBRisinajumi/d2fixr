<?php

// auto-loading
Yii::setPathOfAlias('FpeoPeriodOdo', dirname(__FILE__));
Yii::import('FpeoPeriodOdo.*');

class FpeoPeriodOdo extends BaseFpeoPeriodOdo
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
        return (string) $this->fpeo_distance . ' km';
    }

    public function getItemPeriodLabel()
    {
        return $this->getItemLabel();
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
         , array(
          array('fpeo_start_date,fpeo_distance', 'required'),

          )
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
    
    public function beforeSave()
    {
        //validate rigts to record
        if(!$this->isNewRecord && !FpeoPeriodOdo::model()->findByPk($this->primaryKey)){
            return false;
        }

        //get fixr for truck
        $fixr = FixrFiitXRef::model()->findByPk($this->fpeo_fixr_id);
        if(!$fixr){
            $this->addError('fpeo_id','Can not find fixr record');
            return false;
        }
        
        //found fret record - definitiom
        if(empty($fixr->fixrPositionFret)){
            $this->addError('fpeo_id','No defined position');
            return false;            
        }
        $position_model = $fixr->fixrPositionFret->fret_model;
        $position_model_fixr_field = $fixr->fixrPositionFret->fret_model_fixr_id_field;
        
        //process position model
        $position = new $position_model;
        $position_data = $position->findByAttributes(array($position_model_fixr_field => $this->fpeo_fixr_id));
        if(empty($fixr->fixrPositionFret)){
            $this->addError('fpeo_id','No found position data');
            return false;            
        }
        
        //find in position model vtrc_id - truck field
        $vtrc_id = false;
        foreach($position_data->attributes as $col_name => $col_value){
            if(substr($col_name, -7) == 'vtrc_id'){
                $vtrc_id = $col_value;
                break;
            }
        }
        
        if(!$vtrc_id){
            $this->addError('fpeo_id','In position data no exist vtrc_id columns');
            return false;            
        }        
        
        //get nearest odometer reading by date
        $vodo = VodoOdometer::getOdoByDate($vtrc_id, $this->fpeo_start_date);
        if(!$vodo){
            $this->addError('fpeo_id','No found odometer readings for car');
            return false;            
        }                
        
        //get data from odometer reading
        $this->fpeo_vodo_id = $vodo->vodo_id;
        $this->fpeo_start_abs_odo = $vodo->vodo_abs_odo;
        $this->fpeo_end_abs_odo = $vodo->vodo_abs_odo + $this->fpeo_distance;

        //end date
        $vtrc = VtrcTruck::model()->findByPk($vtrc_id);
        if(empty($vtrc->vtrc_year_mileage)){
           $this->addError('fpeo_id','Pleas set for truc Yearly Run');
           return false; 
        }
        
        $sql_expr = new CDbExpression("ADDDATE(:date,:days)");
        $sql_expr->params = array(
            ':date'=>$this->fpeo_start_date,
            ':days'=>round($this->fpeo_distance/$vtrc->vtrc_year_mileage*365),
        );
        $this->fpeo_end_date = $sql_expr;
        
        return parent::beforeSave();

    }    
    
    /**
     * common name for FddaDimData
     * @return date
     */
    public function getFddaDateFrom(){
        return $this->fpeo_start_date;
    }

    /**
     * common name for FddaDimData
     * @return date
     */    
    public function getFddaDateTo(){
        return $this->fpeo_end_date;
    }

}
