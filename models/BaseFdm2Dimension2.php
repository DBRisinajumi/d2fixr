<?php

/**
 * This is the model base class for the table "fdm2_dimension2".
 *
 * Columns in table "fdm2_dimension2" available as properties of the model:
 * @property string $fdm2_id
 * @property integer $fdm2_fret_id
 * @property string $fdm2_code
 * @property string $fdm2_name
 * @property integer $fdm2_hidden
 *
 * Relations of table "fdm2_dimension2" available as properties of the model:
 * @property FddaDimData[] $fddaDimDatas
 * @property FretRefType $fdm2Fret
 * @property Fdm3Dimension3[] $fdm3Dimension3s
 */
abstract class BaseFdm2Dimension2 extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'fdm2_dimension2';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('fdm2_fret_id', 'required'),
                array('fdm2_code, fdm2_name, fdm2_hidden', 'default', 'setOnEmpty' => true, 'value' => null),
                array('fdm2_fret_id, fdm2_hidden', 'numerical', 'integerOnly' => true),
                array('fdm2_code', 'length', 'max' => 10),
                array('fdm2_name', 'length', 'max' => 50),
                array('fdm2_id, fdm2_fret_id, fdm2_code, fdm2_name, fdm2_hidden', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->fdm2_code;
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
                'fddaDimDatas' => array(self::HAS_MANY, 'FddaDimData', 'fdda_fdm2_id'),
                'fdm2Fret' => array(self::BELONGS_TO, 'FretRefType', 'fdm2_fret_id'),
                'fdm3Dimension3s' => array(self::HAS_MANY, 'Fdm3Dimension3', 'fdm3_fdm2_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'fdm2_id' => Yii::t('D2fixrModule.model', 'Fdm2'),
            'fdm2_fret_id' => Yii::t('D2fixrModule.model', 'Fdm2 Fret'),
            'fdm2_code' => Yii::t('D2fixrModule.model', 'Fdm2 Code'),
            'fdm2_name' => Yii::t('D2fixrModule.model', 'Fdm2 Name'),
            'fdm2_hidden' => Yii::t('D2fixrModule.model', 'Fdm2 Hidden'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.fdm2_id', $this->fdm2_id, true);
        $criteria->compare('t.fdm2_fret_id', $this->fdm2_fret_id);
        $criteria->compare('t.fdm2_code', $this->fdm2_code, true);
        $criteria->compare('t.fdm2_name', $this->fdm2_name, true);
        $criteria->compare('t.fdm2_hidden', $this->fdm2_hidden);


        return $criteria;

    }

}
