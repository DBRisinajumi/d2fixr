<?php

/**
 * This is the model base class for the table "fdm1_dimension1".
 *
 * Columns in table "fdm1_dimension1" available as properties of the model:
 * @property integer $fdm1_id
 * @property string $fdm1_code
 * @property string $fdm1_name
 * @property integer $fdm1_hidden
 *
 * Relations of table "fdm1_dimension1" available as properties of the model:
 * @property FddaDimData[] $fddaDimDatas
 * @property FddpDimDataPeriod[] $fddpDimDataPeriods
 * @property Fdm2Dimension2[] $fdm2Dimension2s
 * @property Fdm3Dimension3[] $fdm3Dimension3s
 * @property FretRefType[] $fretRefTypes
 */
abstract class BaseFdm1Dimension1 extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'fdm1_dimension1';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('fdm1_code, fdm1_name', 'required'),
                array('fdm1_hidden', 'default', 'setOnEmpty' => true, 'value' => null),
                array('fdm1_hidden', 'numerical', 'integerOnly' => true),
                array('fdm1_code', 'length', 'max' => 10),
                array('fdm1_name', 'length', 'max' => 50),
                array('fdm1_id, fdm1_code, fdm1_name, fdm1_hidden', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->fdm1_code;
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
                'fddaDimDatas' => array(self::HAS_MANY, 'FddaDimData', 'fdda_fdm1_id'),
                'fddpDimDataPeriods' => array(self::HAS_MANY, 'FddpDimDataPeriod', 'fddp_fdm1_id'),
                'fdm2Dimension2s' => array(self::HAS_MANY, 'Fdm2Dimension2', 'fdm2_fdm1_id'),
                'fdm3Dimension3s' => array(self::HAS_MANY, 'Fdm3Dimension3', 'fdm3_fdm1_id'),
                'fretRefTypes' => array(self::HAS_MANY, 'FretRefType', 'fret_fdm1_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'fdm1_id' => Yii::t('D2fixrModule.model', 'Fdm1'),
            'fdm1_code' => Yii::t('D2fixrModule.model', 'Fdm1 Code'),
            'fdm1_name' => Yii::t('D2fixrModule.model', 'Fdm1 Name'),
            'fdm1_hidden' => Yii::t('D2fixrModule.model', 'Fdm1 Hidden'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.fdm1_id', $this->fdm1_id);
        $criteria->compare('t.fdm1_code', $this->fdm1_code, true);
        $criteria->compare('t.fdm1_name', $this->fdm1_name, true);
        $criteria->compare('t.fdm1_hidden', $this->fdm1_hidden);


        return $criteria;

    }

}
