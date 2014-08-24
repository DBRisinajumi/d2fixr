<?php

/**
 * This is the model base class for the table "fdm3_dimension3".
 *
 * Columns in table "fdm3_dimension3" available as properties of the model:
 * @property string $fdm3_id
 * @property integer $fdm3_fret_id
 * @property string $fdm3_fdm2_id
 * @property string $fdm3_code
 * @property string $fdm3_name
 * @property integer $fdm3_hidden
 *
 * Relations of table "fdm3_dimension3" available as properties of the model:
 * @property FddaDimData[] $fddaDimDatas
 * @property Fdm2Dimension2 $fdm3Fdm2
 * @property FretRefType $fdm3Fret
 */
abstract class BaseFdm3Dimension3 extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'fdm3_dimension3';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('fdm3_fret_id, fdm3_fdm2_id', 'required'),
                array('fdm3_code, fdm3_name, fdm3_hidden', 'default', 'setOnEmpty' => true, 'value' => null),
                array('fdm3_fret_id, fdm3_hidden', 'numerical', 'integerOnly' => true),
                array('fdm3_fdm2_id, fdm3_code', 'length', 'max' => 10),
                array('fdm3_name', 'length', 'max' => 50),
                array('fdm3_id, fdm3_fret_id, fdm3_fdm2_id, fdm3_code, fdm3_name, fdm3_hidden', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->fdm3_fdm2_id;
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
                'fddaDimDatas' => array(self::HAS_MANY, 'FddaDimData', 'fdda_fdm3_id'),
                'fdm3Fdm2' => array(self::BELONGS_TO, 'Fdm2Dimension2', 'fdm3_fdm2_id'),
                'fdm3Fret' => array(self::BELONGS_TO, 'FretRefType', 'fdm3_fret_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'fdm3_id' => Yii::t('D2fixrModule.model', 'Fdm3'),
            'fdm3_fret_id' => Yii::t('D2fixrModule.model', 'Fdm3 Fret'),
            'fdm3_fdm2_id' => Yii::t('D2fixrModule.model', 'Fdm3 Fdm2'),
            'fdm3_code' => Yii::t('D2fixrModule.model', 'Fdm3 Code'),
            'fdm3_name' => Yii::t('D2fixrModule.model', 'Fdm3 Name'),
            'fdm3_hidden' => Yii::t('D2fixrModule.model', 'Fdm3 Hidden'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.fdm3_id', $this->fdm3_id, true);
        $criteria->compare('t.fdm3_fret_id', $this->fdm3_fret_id);
        $criteria->compare('t.fdm3_fdm2_id', $this->fdm3_fdm2_id);
        $criteria->compare('t.fdm3_code', $this->fdm3_code, true);
        $criteria->compare('t.fdm3_name', $this->fdm3_name, true);
        $criteria->compare('t.fdm3_hidden', $this->fdm3_hidden);


        return $criteria;

    }

}
