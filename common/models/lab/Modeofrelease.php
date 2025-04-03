<?php

namespace common\models\lab;

use Yii;
use common\models\lab\Booking;

/**
 * This is the model class for table "tbl_modeofrelease".
 *
 * @property integer $modeofrelease_id
 * @property string $mode
 * @property integer $status
 *
 * @property Request[] $requests
 */
class Modeofrelease extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_modeofrelease';
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
            [['modeofrelease_id', 'mode', 'status'], 'required'],
            [['modeofrelease_id', 'status'], 'integer'],
            [['mode'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'modeofrelease_id' => 'Modeofrelease ID',
            'mode' => 'Mode',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['modeofrelease_id' => 'modeofrelease_id']);
    }
        public function getModeofrelease()
    {
        return $this->hasOne(Booking::className(), ['modeofrelease_ids' => 'modeofrelease_id']);
    }
}
