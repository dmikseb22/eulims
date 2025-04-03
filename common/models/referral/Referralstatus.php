<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_referralstatus".
 *
 * @property int $referralstatus_id
 * @property string $status_name
 * @property int $enabled
 *
 * @property Statuslogs[] $statuslogs
 */
class Referralstatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_referralstatus';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('referraldb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_name', 'enabled'], 'required'],
            [['enabled'], 'integer'],
            [['status_name'], 'string', 'max' => 75],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'referralstatus_id' => 'Referralstatus ID',
            'status_name' => 'Status Name',
            'enabled' => 'Enabled',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatuslogs()
    {
        return $this->hasMany(Statuslogs::className(), ['referralstatus_id' => 'referralstatus_id']);
    }
}
