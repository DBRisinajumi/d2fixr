<?php

/**
 * This is the model base class for the table "fdpe_dim_period".
 *
 * Columns in table "fdpe_dim_period" available as properties of the model:
 * @property string $fdpe_id
 * @property string $fdpe_type
 * @property string $fdpe_dt_from
 * @property string $fdpe_dt_to
 *
 * Relations of table "fdpe_dim_period" available as properties of the model:
 * @property FddpDimDataPeriod[] $fddpDimDataPeriods
 */
abstract class BaseFdpeDimPeriod extends CActiveRecord
{
    /**
    * ENUM field values
    */
    const FDPE_TYPE_MONTLY = 'Montly';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'fdpe_dim_period';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('fdpe_type, fdpe_dt_from, fdpe_dt_to', 'required'),
                array('fdpe_type', 'length', 'max' => 6),
                array('fdpe_id, fdpe_type, fdpe_dt_from, fdpe_dt_to', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->fdpe_type;
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
                'fddpDimDataPeriods' => array(self::HAS_MANY, 'FddpDimDataPeriod', 'fddp_fdpe_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'fdpe_id' => Yii::t('D2fixrModule.model', 'Fdpe'),
            'fdpe_type' => Yii::t('D2fixrModule.model', 'Fdpe Type'),
            'fdpe_dt_from' => Yii::t('D2fixrModule.model', 'Fdpe Dt From'),
            'fdpe_dt_to' => Yii::t('D2fixrModule.model', 'Fdpe Dt To'),
        );
    }

    public function enumLabels()
    {
        return array(
           'fdpe_type' => array(
               self::FDPE_TYPE_MONTLY => Yii::t('D2fixrModule.model', 'FDPE_TYPE_MONTLY'),
           ),
            );
    }

    public function getEnumFieldLabels($column){

        $aLabels = $this->enumLabels();
        return $aLabels[$column];
    }

    public function getEnumLabel($column,$value){

        $aLabels = $this->enumLabels();

        if(!isset($aLabels[$column])){
            return $value;
        }

        if(!isset($aLabels[$column][$value])){
            return $value;
        }

        return $aLabels[$column][$value];
    }


    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.fdpe_id', $this->fdpe_id, true);
        $criteria->compare('t.fdpe_type', $this->fdpe_type, true);
        $criteria->compare('t.fdpe_dt_from', $this->fdpe_dt_from, true);
        $criteria->compare('t.fdpe_dt_to', $this->fdpe_dt_to, true);


        return $criteria;

    }

}
