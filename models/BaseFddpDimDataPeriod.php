<?php

/**
 * This is the model base class for the table "fddp_dim_data_period".
 *
 * Columns in table "fddp_dim_data_period" available as properties of the model:
 * @property string $fddp_id
 * @property string $fddp_fdda_id
 * @property string $fddp_fdpe_id
 * @property integer $fddp_amt
 * @property string $fddp_fixr_id
 * @property integer $fddp_fret_id
 * @property string $fddp_fdm2_id
 * @property string $fddp_fdm3_id
 *
 * Relations of table "fddp_dim_data_period" available as properties of the model:
 * @property Fdm3Dimension3 $fddpFdm3
 * @property FddaDimData $fddpFdda
 * @property FdpeDimPeriod $fddpFdpe
 * @property FixrFiitXRef $fddpFixr
 * @property FretRefType $fddpFret
 * @property Fdm2Dimension2 $fddpFdm2
 */
abstract class BaseFddpDimDataPeriod extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'fddp_dim_data_period';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('fddp_fdda_id, fddp_fdpe_id, fddp_amt, fddp_fixr_id, fddp_fret_id, fddp_fdm2_id, fddp_fdm3_id', 'required'),
                array('fddp_amt, fddp_fret_id', 'numerical', 'integerOnly' => true),
                array('fddp_fdda_id, fddp_fdpe_id, fddp_fixr_id, fddp_fdm2_id, fddp_fdm3_id', 'length', 'max' => 10),
                array('fddp_id, fddp_fdda_id, fddp_fdpe_id, fddp_amt, fddp_fixr_id, fddp_fret_id, fddp_fdm2_id, fddp_fdm3_id', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->fddp_fdda_id;
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
                'fddpFdm3' => array(self::BELONGS_TO, 'Fdm3Dimension3', 'fddp_fdm3_id'),
                'fddpFdda' => array(self::BELONGS_TO, 'FddaDimData', 'fddp_fdda_id'),
                'fddpFdpe' => array(self::BELONGS_TO, 'FdpeDimPeriod', 'fddp_fdpe_id'),
                'fddpFixr' => array(self::BELONGS_TO, 'FixrFiitXRef', 'fddp_fixr_id'),
                'fddpFret' => array(self::BELONGS_TO, 'FretRefType', 'fddp_fret_id'),
                'fddpFdm2' => array(self::BELONGS_TO, 'Fdm2Dimension2', 'fddp_fdm2_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'fddp_id' => Yii::t('D2fixrModule.model', 'Fddp'),
            'fddp_fdda_id' => Yii::t('D2fixrModule.model', 'Fddp Fdda'),
            'fddp_fdpe_id' => Yii::t('D2fixrModule.model', 'Fddp Fdpe'),
            'fddp_amt' => Yii::t('D2fixrModule.model', 'Fddp Amt'),
            'fddp_fixr_id' => Yii::t('D2fixrModule.model', 'Fddp Fixr'),
            'fddp_fret_id' => Yii::t('D2fixrModule.model', 'Fddp Fret'),
            'fddp_fdm2_id' => Yii::t('D2fixrModule.model', 'Fddp Fdm2'),
            'fddp_fdm3_id' => Yii::t('D2fixrModule.model', 'Fddp Fdm3'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.fddp_id', $this->fddp_id, true);
        $criteria->compare('t.fddp_fdda_id', $this->fddp_fdda_id);
        $criteria->compare('t.fddp_fdpe_id', $this->fddp_fdpe_id);
        $criteria->compare('t.fddp_amt', $this->fddp_amt);
        $criteria->compare('t.fddp_fixr_id', $this->fddp_fixr_id);
        $criteria->compare('t.fddp_fret_id', $this->fddp_fret_id);
        $criteria->compare('t.fddp_fdm2_id', $this->fddp_fdm2_id);
        $criteria->compare('t.fddp_fdm3_id', $this->fddp_fdm3_id);


        return $criteria;

    }

}
