<?php

namespace common\models\address;

use Yii;

/**
 * This is the model class for table "tbl_region".
 *
 * @property int $region_id
 * @property string $psgc_code
 * @property string $reg_desc
 * @property string $reg_code
 *
 * @property Province[] $provinces
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_region';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('addressdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reg_desc'], 'string'],
            [['psgc_code', 'reg_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'region_id' => 'Region ID',
            'psgc_code' => 'Psgc Code',
            'reg_desc' => 'Reg Desc',
            'reg_code' => 'Reg Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvinces()
    {
        return $this->hasMany(Province::className(), ['region_id' => 'region_id']);
    }
}
