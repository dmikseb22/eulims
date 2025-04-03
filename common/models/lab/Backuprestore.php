<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_backuprestore".
 *
 * @property int $id
 * @property string $activity
 * @property string $date
 * @property string $data
 * @property string $status
  * @property string $month
    * @property string $year
     * @property string $customer
 */
class Backuprestore extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_backuprestore';
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
            [['id', 'activity', 'date', 'data', 'status'], 'required'],
            [['id'], 'integer'],
            [['activity', 'date', 'data', 'status'], 'string', 'max' => 200],
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
            'activity' => 'Activity',
            'date' => 'Date',
            'data' => 'No. of Request',
            'status' => 'Status',
            'month' => 'No. of Samples',
            'year' => 'No. of Analyses',
            'customer' => 'No. of Customer',
        ];
    }
}
