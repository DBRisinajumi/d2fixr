<?php

/**
 * This is the model base class for the table "fdda_dim_data".
 *
 * Columns in table "fdda_dim_data" available as properties of the model:
 * @property string $fdda_id
 * @property string $fdda_sys_ccmp_id
 * @property string $fdda_fixr_id
 * @property integer $fdda_fret_id
 * @property integer $fdda_fdm1_id
 * @property string $fdda_fdm2_id
 * @property string $fdda_fdm3_id
 * @property string $fdda_amt
 * @property string $fdda_date_from
 * @property string $fdda_date_to
 *
 * Relations of table "fdda_dim_data" available as properties of the model:
 * @property FretRefType $fddaFret
 * @property Fdm2Dimension2 $fddaFdm2
 * @property Fdm3Dimension3 $fddaFdm3
 * @property FixrFiitXRef $fddaFixr
 * @property Fdm1Dimension1 $fddaFdm1
 * @property FddpDimDataPeriod[] $fddpDimDataPeriods
 */
abstract class BaseFddaDimData extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'fdda_dim_data';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('fdda_fixr_id, fdda_fret_id, fdda_fdm2_id, fdda_fdm3_id', 'required'),
                array('fdda_sys_ccmp_id, fdda_fdm1_id, fdda_amt, fdda_date_from, fdda_date_to', 'default', 'setOnEmpty' => true, 'value' => null),
                array('fdda_fret_id, fdda_fdm1_id', 'numerical', 'integerOnly' => true),
                array('fdda_sys_ccmp_id, fdda_fixr_id, fdda_fdm2_id, fdda_fdm3_id, fdda_amt', 'length', 'max' => 10),
                array('fdda_date_from, fdda_date_to', 'safe'),
                array('fdda_id, fdda_sys_ccmp_id, fdda_fixr_id, fdda_fret_id, fdda_fdm1_id, fdda_fdm2_id, fdda_fdm3_id, fdda_amt, fdda_date_from, fdda_date_to', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->fdda_sys_ccmp_id;
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
                'fddaFret' => array(self::BELONGS_TO, 'FretRefType', 'fdda_fret_id'),
                'fddaFdm2' => array(self::BELONGS_TO, 'Fdm2Dimension2', 'fdda_fdm2_id'),
                'fddaFdm3' => array(self::BELONGS_TO, 'Fdm3Dimension3', 'fdda_fdm3_id'),
                'fddaFixr' => array(self::BELONGS_TO, 'FixrFiitXRef', 'fdda_fixr_id'),
                'fddaFdm1' => array(self::BELONGS_TO, 'Fdm1Dimension1', 'fdda_fdm1_id'),
                'fddpDimDataPeriods' => array(self::HAS_MANY, 'FddpDimDataPeriod', 'fddp_fdda_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'fdda_id' => Yii::t('D2fixrModule.model', 'Fdda'),
            'fdda_sys_ccmp_id' => Yii::t('D2fixrModule.model', 'Fdda Sys Ccmp'),
            'fdda_fixr_id' => Yii::t('D2fixrModule.model', 'Fdda Fixr'),
            'fdda_fret_id' => Yii::t('D2fixrModule.model', 'Fdda Fret'),
            'fdda_fdm1_id' => Yii::t('D2fixrModule.model', 'Fdda Fdm1'),
            'fdda_fdm2_id' => Yii::t('D2fixrModule.model', 'Fdda Fdm2'),
            'fdda_fdm3_id' => Yii::t('D2fixrModule.model', 'Fdda Fdm3'),
            'fdda_amt' => Yii::t('D2fixrModule.model', 'Fdda Amt'),
            'fdda_date_from' => Yii::t('D2fixrModule.model', 'Fdda Date From'),
            'fdda_date_to' => Yii::t('D2fixrModule.model', 'Fdda Date To'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.fdda_id', $this->fdda_id, true);
        $criteria->compare('t.fdda_sys_ccmp_id', $this->fdda_sys_ccmp_id, true);
        $criteria->compare('t.fdda_fixr_id', $this->fdda_fixr_id);
        $criteria->compare('t.fdda_fret_id', $this->fdda_fret_id);
        $criteria->compare('t.fdda_fdm1_id', $this->fdda_fdm1_id);
        $criteria->compare('t.fdda_fdm2_id', $this->fdda_fdm2_id);
        $criteria->compare('t.fdda_fdm3_id', $this->fdda_fdm3_id);
        $criteria->compare('t.fdda_amt', $this->fdda_amt, true);
        $criteria->compare('t.fdda_date_from', $this->fdda_date_from, true);
        $criteria->compare('t.fdda_date_to', $this->fdda_date_to, true);


        return $criteria;

    }

}
