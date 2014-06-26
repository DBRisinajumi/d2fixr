<?php

/**
 * This is the model base class for the table "fixr_fiit_x_ref".
 *
 * Columns in table "fixr_fiit_x_ref" available as properties of the model:
 * @property string $fixr_id
 * @property string $fixr_fiit_id
 * @property integer $fixr_fret_id
 * @property integer $fixr_frep_id
 * @property string $fixr_fcrn_date
 * @property integer $fixr_fcrn_id
 * @property string $fixr_amt
 * @property integer $fixr_base_fcrn_id
 * @property string $fixr_base_amt
 *
 * Relations of table "fixr_fiit_x_ref" available as properties of the model:
 * @property FcrnCurrency $fixrBaseFcrn
 * @property FiitInvoiceItem $fixrFiit
 * @property FretRefType $fixrFret
 * @property FrepRefPeriod $fixrFrep
 * @property FcrnCurrency $fixrFcrn
 * @property FpedPeriodDate[] $fpedPeriodDates
 * @property FpeoPeriodOdo[] $fpeoPeriodOdos
 * @property VtdcTruckDoc[] $vtdcTruckDocs
 */
abstract class BaseFixrFiitXRef extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'fixr_fiit_x_ref';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('fixr_fiit_id, fixr_fcrn_date, fixr_fcrn_id, fixr_base_fcrn_id', 'required'),
                array('fixr_fret_id, fixr_frep_id, fixr_amt, fixr_base_amt', 'default', 'setOnEmpty' => true, 'value' => null),
                array('fixr_fret_id, fixr_frep_id, fixr_fcrn_id, fixr_base_fcrn_id', 'numerical', 'integerOnly' => true),
                array('fixr_fiit_id, fixr_amt, fixr_base_amt', 'length', 'max' => 10),
                array('fixr_id, fixr_fiit_id, fixr_fret_id, fixr_frep_id, fixr_fcrn_date, fixr_fcrn_id, fixr_amt, fixr_base_fcrn_id, fixr_base_amt', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->fixr_fiit_id;
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
                'fixrBaseFcrn' => array(self::BELONGS_TO, 'FcrnCurrency', 'fixr_base_fcrn_id'),
                'fixrFiit' => array(self::BELONGS_TO, 'FiitInvoiceItem', 'fixr_fiit_id'),
                'fixrFret' => array(self::BELONGS_TO, 'FretRefType', 'fixr_fret_id'),
                'fixrFrep' => array(self::BELONGS_TO, 'FrepRefPeriod', 'fixr_frep_id'),
                'fixrFcrn' => array(self::BELONGS_TO, 'FcrnCurrency', 'fixr_fcrn_id'),
                'fpedPeriodDates' => array(self::HAS_MANY, 'FpedPeriodDate', 'fped_fixr_id'),
                'fpeoPeriodOdos' => array(self::HAS_MANY, 'FpeoPeriodOdo', 'fpeo_fixr_id'),
                'vtdcTruckDocs' => array(self::HAS_MANY, 'VtdcTruckDoc', 'vtdc_fixr_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'fixr_id' => Yii::t('D2fixrModule.model', 'Fixr'),
            'fixr_fiit_id' => Yii::t('D2fixrModule.model', 'Fixr Fiit'),
            'fixr_fret_id' => Yii::t('D2fixrModule.model', 'Fixr Fret'),
            'fixr_frep_id' => Yii::t('D2fixrModule.model', 'Fixr Frep'),
            'fixr_fcrn_date' => Yii::t('D2fixrModule.model', 'Fixr Fcrn Date'),
            'fixr_fcrn_id' => Yii::t('D2fixrModule.model', 'Fixr Fcrn'),
            'fixr_amt' => Yii::t('D2fixrModule.model', 'Fixr Amt'),
            'fixr_base_fcrn_id' => Yii::t('D2fixrModule.model', 'Fixr Base Fcrn'),
            'fixr_base_amt' => Yii::t('D2fixrModule.model', 'Fixr Base Amt'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.fixr_id', $this->fixr_id, true);
        $criteria->compare('t.fixr_fiit_id', $this->fixr_fiit_id);
        $criteria->compare('t.fixr_fret_id', $this->fixr_fret_id);
        $criteria->compare('t.fixr_frep_id', $this->fixr_frep_id);
        $criteria->compare('t.fixr_fcrn_date', $this->fixr_fcrn_date, true);
        $criteria->compare('t.fixr_fcrn_id', $this->fixr_fcrn_id);
        $criteria->compare('t.fixr_amt', $this->fixr_amt, true);
        $criteria->compare('t.fixr_base_fcrn_id', $this->fixr_base_fcrn_id);
        $criteria->compare('t.fixr_base_amt', $this->fixr_base_amt, true);


        return $criteria;

    }

}
