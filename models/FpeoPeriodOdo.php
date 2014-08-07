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
        return $this->fpeo_distance . ' km';
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
    
    public function save($runValidation = true, $attributes = NULL) 
    {

                if (
                        !empty($this->fpeo_start_abs_odo)
                     && !empty($this->fpeo_end_abs_odo)
                     && empty($this->fpeo_distance)
                        )
                {
                    $this->fpeo_distance = $this->fpeo_end_abs_odo - $this->fpeo_start_abs_odo;
                    $attributes[] = 'fpeo_distance';
                } elseif (
                        !empty($this->fpeo_start_abs_odo)
                     && !empty($this->fpeo_distance)
                     && empty($this->fpeo_end_abs_odo)
                        )
                {
                    $this->fpeo_end_abs_odo = $this->fpeo_start_abs_odo - $this->fpeo_start_abs_odo;
                    $attributes[] = 'fpeo_end_abs_odo';
                }        
         

        
        return parent::save($runValidation, $attributes);
    
    }            

}
