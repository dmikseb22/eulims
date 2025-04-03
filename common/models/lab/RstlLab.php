<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_rstl_lab".
 *
 * @property int $rstl_lab_id
 * @property int $rstl_id
 * @property int $lab_id
 * @property int $created_at
 */
class RstlLab extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_rstl_lab';
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
            [['rstl_id', 'lab_id'], 'required'],
            [['rstl_id', 'lab_id', 'created_at'], 'integer'],
            [['rstl_id', 'lab_id'], 'unique', 'targetAttribute' => ['rstl_id', 'lab_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rstl_lab_id' => 'Rstl Lab ID',
            'rstl_id' => 'Rstl ID',
            'lab_id' => 'Lab ID',
            'created_at' => 'Created At',
        ];
    }
}
