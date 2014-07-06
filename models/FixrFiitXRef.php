<?php

// auto-loading
Yii::setPathOfAlias('FixrFiitXRef', dirname(__FILE__));
Yii::import('FixrFiitXRef.*');

class FixrFiitXRef extends BaseFixrFiitXRef
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

    public function getFretLabel()
    {
        if(empty($this->fixr_id)){
            return Yii::t('D2fixrModule.model', 'Empty');
        }

        if(empty($this->fixr_fret_id)){
            return Yii::t('D2fixrModule.model', 'Empty');
        }
        $fret_lable = $this->fixrFret->fret_label;
        $fret_model = $this->fixrFret->fret_model;
        $fret_ref_id_field = $this->fixrFret->getRefIdFIeldName();
        
        $criteria = new CDbCriteria();
        $criteria->compare($fret_ref_id_field, $this->fixr_id);
        $model = new $fret_model;
        $model = $model->find($criteria);            
        if(!$model){
            return Yii::t('D2fixrModule.model', 'Empty');
        }
        return $fret_lable . ' ' . $model->itemLabel;        
        
    }

    public function getFrepLabel()
    {
        if(empty($this->fixr_id)){
            return Yii::t('D2fixrModule.model', 'Empty');
        }

        if(empty($this->fixr_frep_id)){
            return Yii::t('D2fixrModule.model', 'Empty');
        }
        $frep_lable = $this->fixrFrep->frep_label;
        $frep_model = $this->fixrFrep->frep_model;
        $frep_ref_id_field = $this->fixrFrep->getRefIdFIeldName();
        
        $criteria = new CDbCriteria();
        $criteria->compare($frep_ref_id_field, $this->fixr_id);
        $model = new $frep_model;
        $model = $model->find($criteria);            
        if(!$model){
            return Yii::t('D2fixrModule.model', 'Empty');
        }
        return $frep_lable . ' ' . $model->itemLabel;        
        
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
    
    /**
     * create record with default values
     * @param type $fiit_id
     * @return boolean
     * @throws CHttpException
     */
    public function addRecord($fiit_id){
        
        $fiit = FiitInvoiceItem::model()->findByPk($fiit_id);
        if(!$fiit){
            throw new CHttpException(400, Yii::t('D2fixrModule.crud', 'Invalid fiit_id value: ' . $fiit_id));            
        }
        
        //calculate amt
        $sql = " 
                SELECT 
                    SUM(fixr_amt) as amt_sum 
                FROM 
                    fixr_fiit_x_ref 
                WHERE 
                    fixr_fiit_id = " . $fiit_id;
        $fixr_sum = Yii::app()->db->createCommand($sql)->queryScalar();

        
        //create fixr record
        $model = new FixrFiitXRef;
        $model->fixr_fiit_id = $fiit_id;
        $model->fixr_fcrn_date = $fiit->fiitFinv->finv_date;
        $model->fixr_fcrn_id = $fiit->fiitFinv->finv_fcrn_id;
        $model->fixr_base_fcrn_id = $fiit->fiitFinv->finv_basic_fcrn_id;
        $model->fixr_amt = $fiit->fiit_amt - $fixr_sum;
        
        //save
        try {
            if ($model->save()) {
                return TRUE;
            }else{
                throw new CHttpException(500, var_export($model->getErrors()));
            }            
        } catch (Exception $e) {
            throw new CHttpException(500, $e->getMessage());
        }        
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
