<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_request_type".
 *
 * @property int $request_type_id
 * @property string $request_type
 */
class RequestType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_request_type';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('labdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_type'], 'required'],
            [['request_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'request_type_id' => 'Request Type ID',
            'request_type' => 'Request Type',
        ];
    }
}
