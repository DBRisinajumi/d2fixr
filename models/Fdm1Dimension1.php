<?php

// auto-loading
Yii::setPathOfAlias('Fdm1Dimension1', dirname(__FILE__));
Yii::import('Fdm1Dimension1.*');

class Fdm1Dimension1 extends BaseFdm1Dimension1
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
                return (string) $this->fdm1_name;
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
            'sort'=>array(
                'defaultOrder'=>'fdm1_name',
            )

        ));
    }

    protected function beforeFind() {
        $criteria = new CDbCriteria;
        $criteria->compare('fdm1_sys_ccmp_id', Yii::app()->sysCompany->getActiveCompany());
        $this->dbCriteria->mergeWith($criteria);
        parent::beforeFind();
    }

    protected function beforeSave() {
        
        $this->fdm1_sys_ccmp_id = Yii::app()->sysCompany->getActiveCompany(); 
        return parent::beforeSave();
    }

    
    public static function getPositions($year){
        $sql = " 
            SELECT 
              fdm1_id row_id,
              fdm1_name name 
            FROM
              fdm1_dimension1 
            WHERE
              fdm1_sys_ccmp_id = ".Yii::app()->sysCompany->getActiveCompany()."
            ORDER BY fdm1_name 
               ";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }    
    
}
