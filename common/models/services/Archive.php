<?php

namespace common\models\services;

use Yii;

/**
 * This is the model class for table "tbl_archive".
 *
 * @property int $id
 * @property string $customer
 * @property string $request_no
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 */
class Archive extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_archive';
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
            [['customer', 'request_no', 'content', 'status', 'type', 'requested_at'], 'required'],
            [['content'], 'string'],
            [['requested_at'], 'safe'],
            [['customer', 'request_no'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer' => 'Customer',
            'request_no' => 'Request No',
            'content' => 'Content',
            'status' => 'Status',
            'type' => 'Type',
            'requested_at' => 'Requested At',
        ];
    }
}
