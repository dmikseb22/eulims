<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_restore".
 *
 * @property int $restore_id
 * @property string $year
 * @property string $customer
 * @property string $request
 * @property string $sample
 * @property string $analysis
 * @property string $truncate
 * @property string $sync
 * @property string $status
 */
class Restore extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_restore';
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
            [['year', 'customer', 'request', 'sample', 'analysis', 'truncate', 'sync', 'status'], 'required'],
            [['year', 'customer', 'request', 'sample', 'analysis', 'truncate', 'sync', 'status'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'restore_id' => 'Restore ID',
            'year' => 'Year',
            'customer' => 'Customer',
            'request' => 'Request',
            'sample' => 'Sample',
            'analysis' => 'Analysis',
            'truncate' => 'Truncate',
            'sync' => 'Sync',
            'status' => 'Status',
        ];
    }
}
