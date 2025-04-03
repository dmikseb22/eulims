<?php

namespace common\modules\message\models;

use Yii;

/**
 * This is the model class for table "tbl_convo".
 *
 * @property int $convo_id
 * @property int $userid
 * @property int $userid_two
 */
class Convo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_convo';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('messagedb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'userid_two'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'convo_id' => 'Convo ID',
            'userid' => 'Userid',
            'userid_two' => 'Userid Two',
        ];
    }
}
