<?php

/**
 * This is the model base class for the table "frep_ref_period".
 *
 * Columns in table "frep_ref_period" available as properties of the model:
 * @property integer $frep_id
 * @property string $frep_model
 * @property string $frep_label
 *
 * Relations of table "frep_ref_period" available as properties of the model:
 * @property FixrFiitXRef[] $fixrFiitXRefs
 */
abstract class BaseFrepRefPeriod extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'frep_ref_period';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('frep_model, frep_label', 'required'),
                array('frep_model, frep_label', 'length', 'max' => 50),
                array('frep_id, frep_model, frep_label', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->frep_model;
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
                'fixrFiitXRefs' => array(self::HAS_MANY, 'FixrFiitXRef', 'fixr_frep_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'frep_id' => Yii::t('D2finvModule.model', 'Frep'),
            'frep_model' => Yii::t('D2finvModule.model', 'Frep Model'),
            'frep_label' => Yii::t('D2finvModule.model', 'Frep Label'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.frep_id', $this->frep_id);
        $criteria->compare('t.frep_model', $this->frep_model, true);
        $criteria->compare('t.frep_label', $this->frep_label, true);


        return $criteria;

    }

}
