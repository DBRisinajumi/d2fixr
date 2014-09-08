<?php

// auto-loading
Yii::setPathOfAlias('Fdm2Dimension2', dirname(__FILE__));
Yii::import('Fdm2Dimension2.*');

class Fdm2Dimension2 extends BaseFdm2Dimension2
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
        return (string) $this->fdm2_name;
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
     * get or create record for table
     * @param int $fret_id - ref type (first dimension level)
     * @param int $ref_id - refernce table record id
     * @param string $code 
     * @param string $name
     * @return type
     */
    public static function getDim2Id($fret_id,$ref_id,$code,$name = false){

        if(!$name){
            $name = $code;
        }
        //search existing record
        $criteria = new CDbCriteria;
        $criteria->compare('fdm2_sys_ccmp_id', Yii::app()->sysCompany->getActiveCompany());
        $criteria->compare('fdm2_fret_id', $fret_id);
        $criteria->compare('fdm2_ref_id', $ref_id);
        
        if($fdm2 = Fdm2Dimension2::model()->find($criteria)){
            return $fdm2->fdm2_id;
        }
        
        $fret = FretRefType::model()->findByPk($fret_id);
        
        //add record
        $fdm2 = new Fdm2Dimension2;
        $fdm2->fdm2_sys_ccmp_id = Yii::app()->sysCompany->getActiveCompany();
        $fdm2->fdm2_fret_id = $fret_id;
        $fdm2->fdm2_ref_id = $ref_id;
        $fdm2->fdm2_fdm1_id = $fret->fret_fdm1_id;
        $fdm2->fdm2_code = substr($code,0,10);
        $fdm2->fdm2_name = $name;
        $fdm2->save();
        return $fdm2->primaryKey;
        
    }

    public static function getPositions($year,$fdm1_id){
        $sql = " 
            SELECT 
              fdm2_id row_id,
              fdm2_name name 
            FROM
              fdm2_dimension2
            WHERE 
              fdm2_fdm1_id = {$fdm1_id}
              AND fdm2_sys_ccmp_id = ".Yii::app()->sysCompany->getActiveCompany()."
            ORDER BY fdm2_name 
               ";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }        
    
}
