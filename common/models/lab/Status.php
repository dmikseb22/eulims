<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_status".
 *
 * @property int $status_id
 * @property string $status
 * @property string $class
 * @property string $icon
 *
 * @property Request[] $requests
 * @property Testreport[] $testreports
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_status';
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
            [['status', 'class'], 'string', 'max' => 50],
            [['icon'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'status_id' => 'Status ID',
            'status' => 'Status',
            'class' => 'Class',
            'icon' => 'Icon',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['status_id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestreports()
    {
        return $this->hasMany(Testreport::className(), ['status_id' => 'status_id']);
    }
}
