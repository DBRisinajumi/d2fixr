<?php

/**
 * This is the model base class for the table "fret_ref_type".
 *
 * Columns in table "fret_ref_type" available as properties of the model:
 * @property integer $fret_id
 * @property string $fret_model
 * @property string $fret_model_fixr_id_field
 * @property string $fret_modelpk_field
 * @property string $fret_label
 * @property string $fret_finv_type
 * @property string $fret_controlier_action
 * @property string $fret_view_form
 *
 * Relations of table "fret_ref_type" available as properties of the model:
 * @property FixrFiitXRef[] $fixrFiitXRefs
 */
abstract class BaseFretRefType extends CActiveRecord
{
    /**
    * ENUM field values
    */
    const FRET_FINV_TYPE_IN = 'in';
    const FRET_FINV_TYPE_OUT = 'out';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'fret_ref_type';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('fret_model, fret_label', 'required'),
                array('fret_model_fixr_id_field, fret_modelpk_field, fret_finv_type, fret_controlier_action, fret_view_form', 'default', 'setOnEmpty' => true, 'value' => null),
                array('fret_model', 'length', 'max' => 50),
                array('fret_model_fixr_id_field, fret_modelpk_field, fret_controlier_action, fret_view_form', 'length', 'max' => 100),
                array('fret_label', 'length', 'max' => 250),
                array('fret_finv_type', 'length', 'max' => 3),
                array('fret_id, fret_model, fret_model_fixr_id_field, fret_modelpk_field, fret_label, fret_finv_type, fret_controlier_action, fret_view_form', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->fret_model;
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(), array(
                'savedRelated' => array(
                    'class' => '\GtcSaveRelationsBehavior'
                )
            )
        );
    }

    public function relations()
    {
        return array_merge(
            parent::relations(), array(
                'fixrFiitXRefs' => array(self::HAS_MANY, 'FixrFiitXRef', 'fixr_fret_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'fret_id' => Yii::t('D2fixrModule.model', 'Fret'),
            'fret_model' => Yii::t('D2fixrModule.model', 'Fret Model'),
            'fret_model_fixr_id_field' => Yii::t('D2fixrModule.model', 'Fret Model Fixr Id Field'),
            'fret_modelpk_field' => Yii::t('D2fixrModule.model', 'Fret Modelpk Field'),
            'fret_label' => Yii::t('D2fixrModule.model', 'Fret Label'),
            'fret_finv_type' => Yii::t('D2fixrModule.model', 'Fret Finv Type'),
            'fret_controlier_action' => Yii::t('D2fixrModule.model', 'Fret Controlier Action'),
            'fret_view_form' => Yii::t('D2fixrModule.model', 'Fret View Form'),
        );
    }

    public function enumLabels()
    {
        return array(
           'fret_finv_type' => array(
               self::FRET_FINV_TYPE_IN => Yii::t('D2fixrModule.model', 'FRET_FINV_TYPE_IN'),
               self::FRET_FINV_TYPE_OUT => Yii::t('D2fixrModule.model', 'FRET_FINV_TYPE_OUT'),
           ),
            );
    }

    public function getEnumFieldLabels($column){

        $aLabels = $this->enumLabels();
        return $aLabels[$column];
    }

    public function getEnumLabel($column,$value){

        $aLabels = $this->enumLabels();

        if(!isset($aLabels[$column])){
            return $value;
        }

        if(!isset($aLabels[$column][$value])){
            return $value;
        }

        return $aLabels[$column][$value];
    }


    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.fret_id', $this->fret_id);
        $criteria->compare('t.fret_model', $this->fret_model, true);
        $criteria->compare('t.fret_model_fixr_id_field', $this->fret_model_fixr_id_field, true);
        $criteria->compare('t.fret_modelpk_field', $this->fret_modelpk_field, true);
        $criteria->compare('t.fret_label', $this->fret_label, true);
        $criteria->compare('t.fret_finv_type', $this->fret_finv_type, true);
        $criteria->compare('t.fret_controlier_action', $this->fret_controlier_action, true);
        $criteria->compare('t.fret_view_form', $this->fret_view_form, true);


        return $criteria;

    }

}
