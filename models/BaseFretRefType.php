<?php

/**
 * This is the model base class for the table "fret_ref_type".
 *
 * Columns in table "fret_ref_type" available as properties of the model:
 * @property integer $fret_id
 * @property string $fret_model
 * @property string $fret_label
 *
 * Relations of table "fret_ref_type" available as properties of the model:
 * @property FixrFiitXRef[] $fixrFiitXRefs
 */
abstract class BaseFretRefType extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'fret_ref_type';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('fret_model, fret_label', 'required'),
                array('fret_model, fret_label', 'length', 'max' => 50),
                array('fret_id, fret_model, fret_label', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->fret_model;
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
                'fixrFiitXRefs' => array(self::HAS_MANY, 'FixrFiitXRef', 'fixr_fret_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'fret_id' => Yii::t('D2finvModule.model', 'Fret'),
            'fret_model' => Yii::t('D2finvModule.model', 'Fret Model'),
            'fret_label' => Yii::t('D2finvModule.model', 'Fret Label'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.fret_id', $this->fret_id);
        $criteria->compare('t.fret_model', $this->fret_model, true);
        $criteria->compare('t.fret_label', $this->fret_label, true);


        return $criteria;

    }

}
