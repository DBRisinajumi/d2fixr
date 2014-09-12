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
    
    protected function beforeFind() {
        $criteria = new CDbCriteria;
        $criteria->compare('fdda_sys_ccmp_id', Yii::app()->sysCompany->getActiveCompany());
        $this->dbCriteria->mergeWith($criteria);
        parent::beforeFind();
    }    
    
    public function save($runValidation = true, $attributes = null) {
        
        //get additional data for fdda
        $fdm3 = $this->fddaFdm3;
        $this->fdda_sys_ccmp_id = Yii::app()->sysCompany->getActiveCompany();
        $this->fdda_fdm1_id = $fdm3->fdm3_fdm1_id;
        $this->fdda_fdm2_id = $fdm3->fdm3_fdm2_id;
        $this->fdda_fret_id = $fdm3->fdm3_fret_id;

        $fixr = $this->fddaFixr;
        $this->fdda_amt = 100 * Yii::app()->currency->convertFromTo(
            $fixr->fixr_fcrn_id, Yii::app()->currency->base, $fixr->fixr_amt, $fixr->fixr_fcrn_date
        );

        return parent::save($runValidation, $attributes);
    }
    
    public function afterSave() {

        //save changes in fddp - dimension data periods
        FdpeDimPeriod::savePeriodData($this, FdpeDimPeriod::FDPE_TYPE_MONTLY);
        
        parent::afterSave();
            
    }

    public function beforeDelete() {
        
        //delete related recrd from FddpDimDataPeriod
        $criteria = new CDbCriteria();
        $criteria->compare('fddp_fdda_id',$this->fdda_id);
        foreach(FddpDimDataPeriod::model()->findAll($criteria) as $fddp){
            $fddp->delete();
        }
        
        return parent::beforeDelete();
    }
    
    /**
     * find existing model by fixr_id or create new model with setted fixr_id
     * @param int $fixr_id
     * @return \FddaDimData model
     */
    public static function findByFixrId($fixr_id) {
        $criteria = new CDbCriteria();
        $criteria->compare('fdda_fixr_id',$fixr_id);
        $model = FddaDimData::model()->find($criteria);
        if (empty($model)) {
            $model = new FddaDimData;
            $model->fdda_fixr_id = $fixr_id;
        }
        return $model;
    }

    /**
     * get fdm2_id value and set it
     * @param int $ref_id fdm2_ref_id value
     * @param string $code
     * @param string $name
     */
    public function setFdm2Id($ref_id, $code, $name = false){
        if(empty($this->fdda_fret_id)){
            exit('Before FddaDimData->setFdm2Id require set fdda_fret_id');
        }
        $this->fdda_fdm2_id = Fdm2Dimension2::getDim2Id($this->fdda_fret_id, $ref_id, $code, $name);
    }

    /**
     * get fdm3_id value and set it
     * @param int $ref_id  fdm3_fref_id 
     * @param type $code
     * @param type $name
     */
    public function setFdm3Id($ref_id, $code, $name = false){
        if(empty($this->fdda_fret_id)){
            exit('Before FddaDimData->setFdm2Id require set fdda_fret_id');
        }
        if(empty($this->fdda_fdm2_id)){
            exit('Before FddaDimData->setFdm3Id require set fdda_fdm2_id by FddaDimData->setFdm2Id()');
        }        
        $this->fdda_fdm3_id = Fdm3Dimension3::getDim3Id($this->fdda_fret_id,$this->fdda_fdm2_id, $ref_id, $code, $name);
    }

}
