<?php

// auto-loading
Yii::setPathOfAlias('Fdm3Dimension3', dirname(__FILE__));
Yii::import('Fdm3Dimension3.*');

class Fdm3Dimension3 extends BaseFdm3Dimension3
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
     * get or create record for table
     * @param int $fret_id - ref type (first dimension level)
     * @param int $ref_id - refernce table record id
     * @param string $code 
     * @param string $name
     * @return type
     */
    public static function getDim3Id($fret_id,$fdm2_id,$ref_id,$code,$name = false){

        if(!$name){
            $name = $code;
        }
        
        //search existing record
        $criteria = new CDbCriteria;
        $criteria->compare('fdm3_fret_id', $fret_id);
        $criteria->compare('fdm3_fdm2_id', $fdm2_id);
        $criteria->compare('fdm3_ref_id', $ref_id);
        
        if($fdm3 = Fdm3Dimension3::model()->find($criteria)){
            return $fdm3->fdm3_id;
        }
        
        //add record
        $fdm3 = new Fdm3Dimension3;
        $fdm3->fdm3_fret_id = $fret_id;
        $fdm3->fdm3_ref_id = $ref_id;
        $fdm3->fdm3_fdm2_id = $fdm2_id;
        $fdm3->fdm3_code = substr($code,0,10);
        $fdm3->fdm3_name = $name;
        $fdm3->save();
        return $fdm3->primaryKey;
        
    }    

}