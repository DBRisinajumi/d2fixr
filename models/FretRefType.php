<?php

// auto-loading
Yii::setPathOfAlias('FretRefType', dirname(__FILE__));
Yii::import('FretRefType.*');

class FretRefType extends BaseFretRefType
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
        return (string) $this->fret_label . '-' . $this->fret_finv_type;
    }

    public function getRefIdFIeldName()
    {
        return strtolower(substr($this->fret_model,0,4)) . '_fixr_id';
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
