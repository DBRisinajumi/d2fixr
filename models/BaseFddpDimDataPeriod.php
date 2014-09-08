<?php

/**
 * This is the model base class for the table "fddp_dim_data_period".
 *
 * Columns in table "fddp_dim_data_period" available as properties of the model:
 * @property string $fddp_id
 * @property string $fddp_sys_ccmp_id
 * @property string $fddp_fdda_id
 * @property string $fddp_fdpe_id
 * @property integer $fddp_amt
 * @property string $fddp_fixr_id
 * @property integer $fddp_fret_id
 * @property integer $fddp_fdm1_id
 * @property string $fddp_fdm2_id
 * @property string $fddp_fdm3_id
 * @property integer $fddp_fdst_id
 * @property string $fddp_cd
 * @property string $fddp_fdst_ref_id
 *
 * Relations of table "fddp_dim_data_period" available as properties of the model:
 * @property FretRefType $fddpFret
 * @property FddaDimData $fddpFdda
 * @property FdpeDimPeriod $fddpFdpe
 * @property FixrFiitXRef $fddpFixr
 * @property Fdm2Dimension2 $fddpFdm2
 * @property Fdm3Dimension3 $fddpFdm3
 * @property Fdm1Dimension1 $fddpFdm1
 * @property FdstDimSplitType $fddpFdst
 */
abstract class BaseFddpDimDataPeriod extends CActiveRecord
{
    /**
    * ENUM field values
    */
    const FDDP_CD_C = 'C';
    const FDDP_CD_D = 'D';

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
                array('fddp_sys_ccmp_id, fddp_fdm1_id, fddp_fdst_id, fddp_cd, fddp_fdst_ref_id', 'default', 'setOnEmpty' => true, 'value' => null),
                array('fddp_amt, fddp_fret_id, fddp_fdm1_id, fddp_fdst_id', 'numerical', 'integerOnly' => true),
                array('fddp_sys_ccmp_id, fddp_fdda_id, fddp_fdpe_id, fddp_fixr_id, fddp_fdm2_id, fddp_fdm3_id, fddp_fdst_ref_id', 'length', 'max' => 10),
                array('fddp_cd', 'length', 'max' => 1),
                array('fddp_id, fddp_sys_ccmp_id, fddp_fdda_id, fddp_fdpe_id, fddp_amt, fddp_fixr_id, fddp_fret_id, fddp_fdm1_id, fddp_fdm2_id, fddp_fdm3_id, fddp_fdst_id, fddp_cd, fddp_fdst_ref_id', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->fddp_sys_ccmp_id;
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
                'fddpFret' => array(self::BELONGS_TO, 'FretRefType', 'fddp_fret_id'),
                'fddpFdda' => array(self::BELONGS_TO, 'FddaDimData', 'fddp_fdda_id'),
                'fddpFdpe' => array(self::BELONGS_TO, 'FdpeDimPeriod', 'fddp_fdpe_id'),
                'fddpFixr' => array(self::BELONGS_TO, 'FixrFiitXRef', 'fddp_fixr_id'),
                'fddpFdm2' => array(self::BELONGS_TO, 'Fdm2Dimension2', 'fddp_fdm2_id'),
                'fddpFdm3' => array(self::BELONGS_TO, 'Fdm3Dimension3', 'fddp_fdm3_id'),
                'fddpFdm1' => array(self::BELONGS_TO, 'Fdm1Dimension1', 'fddp_fdm1_id'),
                'fddpFdst' => array(self::BELONGS_TO, 'FdstDimSplitType', 'fddp_fdst_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'fddp_id' => Yii::t('D2fixrModule.model', 'Fddp'),
            'fddp_sys_ccmp_id' => Yii::t('D2fixrModule.model', 'Fddp Sys Ccmp'),
            'fddp_fdda_id' => Yii::t('D2fixrModule.model', 'Fddp Fdda'),
            'fddp_fdpe_id' => Yii::t('D2fixrModule.model', 'Fddp Fdpe'),
            'fddp_amt' => Yii::t('D2fixrModule.model', 'Fddp Amt'),
            'fddp_fixr_id' => Yii::t('D2fixrModule.model', 'Fddp Fixr'),
            'fddp_fret_id' => Yii::t('D2fixrModule.model', 'Fddp Fret'),
            'fddp_fdm1_id' => Yii::t('D2fixrModule.model', 'Fddp Fdm1'),
            'fddp_fdm2_id' => Yii::t('D2fixrModule.model', 'Fddp Fdm2'),
            'fddp_fdm3_id' => Yii::t('D2fixrModule.model', 'Fddp Fdm3'),
            'fddp_fdst_id' => Yii::t('D2fixrModule.model', 'Fddp Fdst'),
            'fddp_cd' => Yii::t('D2fixrModule.model', 'Fddp Cd'),
            'fddp_fdst_ref_id' => Yii::t('D2fixrModule.model', 'Fddp Fdst Ref'),
        );
    }

    public function enumLabels()
    {
        return array(
           'fddp_cd' => array(
               self::FDDP_CD_C => Yii::t('D2fixrModule.model', 'FDDP_CD_C'),
               self::FDDP_CD_D => Yii::t('D2fixrModule.model', 'FDDP_CD_D'),
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

        $criteria->compare('t.fddp_id', $this->fddp_id, true);
        $criteria->compare('t.fddp_sys_ccmp_id', $this->fddp_sys_ccmp_id, true);
        $criteria->compare('t.fddp_fdda_id', $this->fddp_fdda_id);
        $criteria->compare('t.fddp_fdpe_id', $this->fddp_fdpe_id);
        $criteria->compare('t.fddp_amt', $this->fddp_amt);
        $criteria->compare('t.fddp_fixr_id', $this->fddp_fixr_id);
        $criteria->compare('t.fddp_fret_id', $this->fddp_fret_id);
        $criteria->compare('t.fddp_fdm1_id', $this->fddp_fdm1_id);
        $criteria->compare('t.fddp_fdm2_id', $this->fddp_fdm2_id);
        $criteria->compare('t.fddp_fdm3_id', $this->fddp_fdm3_id);
        $criteria->compare('t.fddp_fdst_id', $this->fddp_fdst_id);
        $criteria->compare('t.fddp_cd', $this->fddp_cd, true);
        $criteria->compare('t.fddp_fdst_ref_id', $this->fddp_fdst_ref_id, true);


        return $criteria;

    }

}
