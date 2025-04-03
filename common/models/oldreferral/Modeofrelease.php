<?php

namespace common\models\oldreferral;

use Yii;

/**
 * This is the model class for table "modeofrelease".
 *
 * @property int $id
 * @property string $mode
 * @property int $status
 */
class Modeofrelease extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modeofrelease';
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
            [['id', 'mode', 'status'], 'required'],
            [['id', 'status'], 'integer'],
            [['mode'], 'string', 'max' => 25],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mode' => 'Mode',
            'status' => 'Status',
        ];
    }
}
