<?php

/**
 * This is the model base class for the table "fped_period_date".
 *
 * Columns in table "fped_period_date" available as properties of the model:
 * @property string $fped_id
 * @property string $fped_fixr_id
 * @property string $fped_start_date
 * @property string $fped_end_date
 * @property string $fped_month
 *
 * Relations of table "fped_period_date" available as properties of the model:
 * @property FixrFiitXRef $fpedFixr
 */
abstract class BaseFpedPeriodDate extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'fped_period_date';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('fped_fixr_id', 'required'),
                array('fped_start_date, fped_end_date, fped_month', 'default', 'setOnEmpty' => true, 'value' => null),
                array('fped_fixr_id', 'length', 'max' => 10),
                array('fped_start_date, fped_end_date, fped_month', 'safe'),
                array('fped_id, fped_fixr_id, fped_start_date, fped_end_date, fped_month', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->fped_fixr_id;
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
                'fpedFixr' => array(self::BELONGS_TO, 'FixrFiitXRef', 'fped_fixr_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'fped_id' => Yii::t('D2finvModule.model', 'Fped'),
            'fped_fixr_id' => Yii::t('D2finvModule.model', 'Fped Fixr'),
            'fped_start_date' => Yii::t('D2finvModule.model', 'Fped Start Date'),
            'fped_end_date' => Yii::t('D2finvModule.model', 'Fped End Date'),
            'fped_month' => Yii::t('D2finvModule.model', 'Fped Month'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.fped_id', $this->fped_id, true);
        $criteria->compare('t.fped_fixr_id', $this->fped_fixr_id);
        $criteria->compare('t.fped_start_date', $this->fped_start_date, true);
        $criteria->compare('t.fped_end_date', $this->fped_end_date, true);
        $criteria->compare('t.fped_month', $this->fped_month, true);


        return $criteria;

    }

}
