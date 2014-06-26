<?php

/**
 * This is the model base class for the table "fpeo_period_odo".
 *
 * Columns in table "fpeo_period_odo" available as properties of the model:
 * @property string $fpeo_id
 * @property string $fpeo_fixr_id
 * @property string $fpeo_start_abs_odo
 * @property string $fpeo_end_abs_odo
 * @property string $fpeo_distance
 *
 * Relations of table "fpeo_period_odo" available as properties of the model:
 * @property FixrFiitXRef $fpeoFixr
 */
abstract class BaseFpeoPeriodOdo extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'fpeo_period_odo';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('fpeo_fixr_id', 'required'),
                array('fpeo_start_abs_odo, fpeo_end_abs_odo, fpeo_distance', 'default', 'setOnEmpty' => true, 'value' => null),
                array('fpeo_fixr_id, fpeo_start_abs_odo, fpeo_end_abs_odo, fpeo_distance', 'length', 'max' => 10),
                array('fpeo_id, fpeo_fixr_id, fpeo_start_abs_odo, fpeo_end_abs_odo, fpeo_distance', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->fpeo_fixr_id;
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
                'fpeoFixr' => array(self::BELONGS_TO, 'FixrFiitXRef', 'fpeo_fixr_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'fpeo_id' => Yii::t('D2finvModule.model', 'Fpeo'),
            'fpeo_fixr_id' => Yii::t('D2finvModule.model', 'Fpeo Fixr'),
            'fpeo_start_abs_odo' => Yii::t('D2finvModule.model', 'Fpeo Start Abs Odo'),
            'fpeo_end_abs_odo' => Yii::t('D2finvModule.model', 'Fpeo End Abs Odo'),
            'fpeo_distance' => Yii::t('D2finvModule.model', 'Fpeo Distance'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.fpeo_id', $this->fpeo_id, true);
        $criteria->compare('t.fpeo_fixr_id', $this->fpeo_fixr_id);
        $criteria->compare('t.fpeo_start_abs_odo', $this->fpeo_start_abs_odo, true);
        $criteria->compare('t.fpeo_end_abs_odo', $this->fpeo_end_abs_odo, true);
        $criteria->compare('t.fpeo_distance', $this->fpeo_distance, true);


        return $criteria;

    }

}
