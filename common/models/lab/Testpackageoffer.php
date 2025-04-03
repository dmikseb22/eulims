<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_test_package_offer".
 *
 * @property int $testpackage_offer_id
 * @property int $rstl_id
 * @property int $testpackage_id
 */
class Testpackageoffer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_test_package_offer';
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
            [['rstl_id', 'testpackage_id'], 'required'],
            [['rstl_id', 'testpackage_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'testpackage_offer_id' => 'Testpackage Offer ID',
            'rstl_id' => 'Rstl ID',
            'testpackage_id' => 'Testpackage ID',
        ];
    }
}
