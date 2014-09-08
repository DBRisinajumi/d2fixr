<?php

/**
 * This is the model base class for the table "fdsp_dimension_split".
 *
 * Columns in table "fdsp_dimension_split" available as properties of the model:
 * @property string $fdsp_id
 * @property string $fdsp_sys_ccmp_id
 * @property integer $fdsp_fdm1_id
 * @property string $fdsp_fdm2_id
 * @property string $fdsp_fdm3_id
 * @property integer $fdsp_fdst_id
 * @property integer $fdsp_procenti
 * @property string $fdsp_notes
 *
 * Relations of table "fdsp_dimension_split" available as properties of the model:
 * @property FdstDimSplitType $fdspFdst
 * @property Fdm1Dimension1 $fdspFdm1
 * @property Fdm2Dimension2 $fdspFdm2
 * @property Fdm3Dimension3 $fdspFdm3
 */
abstract class BaseFdspDimensionSplit extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'fdsp_dimension_split';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('fdsp_fdm1_id, fdsp_fdst_id, fdsp_procenti', 'required'),
                array('fdsp_sys_ccmp_id, fdsp_fdm2_id, fdsp_fdm3_id, fdsp_notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('fdsp_fdm1_id, fdsp_fdst_id, fdsp_procenti', 'numerical', 'integerOnly' => true),
                array('fdsp_sys_ccmp_id, fdsp_fdm2_id, fdsp_fdm3_id', 'length', 'max' => 10),
                array('fdsp_notes', 'safe'),
                array('fdsp_id, fdsp_sys_ccmp_id, fdsp_fdm1_id, fdsp_fdm2_id, fdsp_fdm3_id, fdsp_fdst_id, fdsp_procenti, fdsp_notes', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->fdsp_sys_ccmp_id;
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
                'fdspFdst' => array(self::BELONGS_TO, 'FdstDimSplitType', 'fdsp_fdst_id'),
                'fdspFdm1' => array(self::BELONGS_TO, 'Fdm1Dimension1', 'fdsp_fdm1_id'),
                'fdspFdm2' => array(self::BELONGS_TO, 'Fdm2Dimension2', 'fdsp_fdm2_id'),
                'fdspFdm3' => array(self::BELONGS_TO, 'Fdm3Dimension3', 'fdsp_fdm3_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'fdsp_id' => Yii::t('D2fixrModule.model', 'Fdsp'),
            'fdsp_sys_ccmp_id' => Yii::t('D2fixrModule.model', 'Fdsp Sys Ccmp'),
            'fdsp_fdm1_id' => Yii::t('D2fixrModule.model', 'Fdsp Fdm1'),
            'fdsp_fdm2_id' => Yii::t('D2fixrModule.model', 'Fdsp Fdm2'),
            'fdsp_fdm3_id' => Yii::t('D2fixrModule.model', 'Fdsp Fdm3'),
            'fdsp_fdst_id' => Yii::t('D2fixrModule.model', 'Fdsp Fdst'),
            'fdsp_procenti' => Yii::t('D2fixrModule.model', 'Fdsp Procenti'),
            'fdsp_notes' => Yii::t('D2fixrModule.model', 'Fdsp Notes'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.fdsp_id', $this->fdsp_id, true);
        $criteria->compare('t.fdsp_sys_ccmp_id', $this->fdsp_sys_ccmp_id, true);
        $criteria->compare('t.fdsp_fdm1_id', $this->fdsp_fdm1_id);
        $criteria->compare('t.fdsp_fdm2_id', $this->fdsp_fdm2_id);
        $criteria->compare('t.fdsp_fdm3_id', $this->fdsp_fdm3_id);
        $criteria->compare('t.fdsp_fdst_id', $this->fdsp_fdst_id);
        $criteria->compare('t.fdsp_procenti', $this->fdsp_procenti);
        $criteria->compare('t.fdsp_notes', $this->fdsp_notes, true);


        return $criteria;

    }

}
