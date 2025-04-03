<?php

namespace common\models\system;

use Yii;

/**
 * This is the model class for table "vw_labrbac".
 *
 * @property int $user_id
 * @property string $labmanager
 * @property int $lab_id
 * @property string $labname
 * @property int $updated_at
 */
class Labrbac extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vw_labrbac';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'lab_id', 'updated_at'], 'integer'],
            [['labmanager'], 'string', 'max' => 404],
            [['labname'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'labmanager' => 'Labmanager',
            'lab_id' => 'Lab ID',
            'labname' => 'Labname',
            'updated_at' => 'Updated At',
        ];
    }
}
