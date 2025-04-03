<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_packageoffer".
 *
 * @property int $packageoffer_id
 * @property int $agency_id
 * @property int $packagelist_id
 * @property string $offered_date
 */
class Packageoffer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_packageoffer';
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
            [['agency_id', 'packagelist_id', 'offered_date'], 'required'],
            [['agency_id', 'packagelist_id'], 'integer'],
            [['offered_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'packageoffer_id' => 'Packageoffer ID',
            'agency_id' => 'Agency ID',
            'packagelist_id' => 'Packagelist ID',
            'offered_date' => 'Offered Date',
        ];
    }
}
