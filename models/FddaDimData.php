<?php

// auto-loading
Yii::setPathOfAlias('FddaDimData', dirname(__FILE__));
Yii::import('FddaDimData.*');

class FddaDimData extends BaseFddaDimData
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

    public function getItemPositionLabel()
    {
            return ' > '.$this->fddaFdm2->fdm2_name . ' > ' . $this->fddaFdm3->fdm3_name;
    }        

    public function getItemPeriodLabel()
    {
            return ': '.$this->fdda_date_from . ' - ' . $this->fdda_date_to;
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
    
    public function save($runValidation = true, $attributes = null) {
        $fdm3 = $this->fddaFdm3;
        $this->fdda_fdm2_id = $fdm3->fdm3_fdm2_id;
        $this->fdda_fret_id = $fdm3->fdm3_fret_id;

        $fixr = $this->fddaFixr;
        $this->fdda_amt = Yii::app()->currency->convertFromTo(
                $fixr->fixr_fcrn_id, Yii::app()->currency->base, $fixr->fixr_amt, $fixr->fixr_fcrn_date
        );

        parent::save($runValidation, $attributes);
    }

}
