<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_requestcode".
 *
 * @property integer $requestcode_id
 * @property string $request_ref_num
 * @property integer $rstl_id
 * @property integer $lab_id
 * @property integer $number
 * @property integer $year
 * @property integer $cancelled
 *
 * @property Lab $lab
 */
class Requestcode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_requestcode';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('labdb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_ref_num', 'rstl_id', 'lab_id', 'number', 'year', 'cancelled'], 'required'],
            [['rstl_id', 'lab_id', 'number', 'year', 'cancelled'], 'integer'],
            [['request_ref_num'], 'string', 'max' => 50],
            [['lab_id', 'rstl_id', 'year'], 'unique', 'targetAttribute' => ['lab_id', 'rstl_id', 'year']], 
            [['lab_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lab::className(), 'targetAttribute' => ['lab_id' => 'lab_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'requestcode_id' => 'Requestcode ID',
            'request_ref_num' => 'Request Ref Num',
            'rstl_id' => 'Rstl ID',
            'lab_id' => 'Lab ID',
            'number' => 'Number',
            'year' => 'Year',
            'cancelled' => 'Cancelled',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLab()
    {
        return $this->hasOne(Lab::className(), ['lab_id' => 'lab_id']);
    }
}
