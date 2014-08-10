<?php

// auto-loading
Yii::setPathOfAlias('FpedPeriodDate', dirname(__FILE__));
Yii::import('FpedPeriodDate.*');

class FpedPeriodDate extends BaseFpedPeriodDate
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
        return (string) $this->fped_start_date . ' ' . $this->fped_end_date;
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

}
