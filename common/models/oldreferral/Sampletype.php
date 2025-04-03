<?php

namespace common\models\oldreferral;

use Yii;

/**
 * This is the model class for table "sampletype".
 *
 * @property int $id
 * @property string $type
 * @property int $status_id
 */
class Sampletype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sampletype';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('oldreferraldb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'status_id'], 'required'],
            [['status_id'], 'integer'],
            [['type'], 'string', 'max' => 75],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'status_id' => 'Status ID',
        ];
    }
}
