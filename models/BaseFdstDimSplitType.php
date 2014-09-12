<?php

/**
 * This is the model base class for the table "fdst_dim_split_type".
 *
 * Columns in table "fdst_dim_split_type" available as properties of the model:
 * @property integer $fdst_id
 * @property string $fdst_sys_ccmp_id
 * @property string $fdst_code
 * @property string $fdst_name
 * @property string $fdst_type
 * @property integer $fdst_dim_level
 * @property string $fdst_notes
 *
 * Relations of table "fdst_dim_split_type" available as properties of the model:
 * @property FddpDimDataPeriod[] $fddpDimDataPeriods
 * @property FdspDimensionSplit[] $fdspDimensionSplits
 */
abstract class BaseFdstDimSplitType extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'fdst_dim_split_type';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('fdst_code, fdst_name', 'required'),
                array('fdst_sys_ccmp_id, fdst_type, fdst_dim_level, fdst_notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('fdst_dim_level', 'numerical', 'integerOnly' => true),
                array('fdst_sys_ccmp_id, fdst_code, fdst_type', 'length', 'max' => 10),
                array('fdst_name', 'length', 'max' => 20),
                array('fdst_notes', 'safe'),
                array('fdst_id, fdst_sys_ccmp_id, fdst_code, fdst_name, fdst_type, fdst_dim_level, fdst_notes', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->fdst_sys_ccmp_id;
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
                'fddpDimDataPeriods' => array(self::HAS_MANY, 'FddpDimDataPeriod', 'fddp_fdst_id'),
                'fdspDimensionSplits' => array(self::HAS_MANY, 'FdspDimensionSplit', 'fdsp_fdst_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'fdst_id' => Yii::t('D2fixrModule.model', 'Fdst'),
            'fdst_sys_ccmp_id' => Yii::t('D2fixrModule.model', 'Fdst Sys Ccmp'),
            'fdst_code' => Yii::t('D2fixrModule.model', 'Fdst Code'),
            'fdst_name' => Yii::t('D2fixrModule.model', 'Fdst Name'),
            'fdst_type' => Yii::t('D2fixrModule.model', 'Fdst Type'),
            'fdst_dim_level' => Yii::t('D2fixrModule.model', 'Fdst Dim Level'),
            'fdst_notes' => Yii::t('D2fixrModule.model', 'Fdst Notes'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.fdst_id', $this->fdst_id);
        $criteria->compare('t.fdst_sys_ccmp_id', $this->fdst_sys_ccmp_id, true);
        $criteria->compare('t.fdst_code', $this->fdst_code, true);
        $criteria->compare('t.fdst_name', $this->fdst_name, true);
        $criteria->compare('t.fdst_type', $this->fdst_type, true);
        $criteria->compare('t.fdst_dim_level', $this->fdst_dim_level);
        $criteria->compare('t.fdst_notes', $this->fdst_notes, true);


        return $criteria;

    }

}
