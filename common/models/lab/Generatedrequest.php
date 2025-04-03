<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_generatedrequest".
 *
 * @property integer $generatedrequest_id
 * @property integer $rstl_id
 * @property integer $request_id
 * @property integer $lab_id
 * @property integer $year
 * @property integer $number
 *
 * @property Request $request
 */
class Generatedrequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_generatedrequest';
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
            [['rstl_id', 'request_id', 'lab_id', 'year', 'number'], 'integer'],
            [['year', 'number'], 'required'],
            [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Request::className(), 'targetAttribute' => ['request_id' => 'request_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'generatedrequest_id' => 'Generatedrequest ID',
            'rstl_id' => 'Rstl ID',
            'request_id' => 'Request ID',
            'lab_id' => 'Lab ID',
            'year' => 'Year',
            'number' => 'Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['request_id' => 'request_id']);
    }
}
