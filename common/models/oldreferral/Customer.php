<?php

namespace common\models\oldreferral;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $customerName
 * @property string $agencyHead
 * @property int $region_id
 * @property int $province_id
 * @property int $municipalityCity_id
 * @property int $barangay_id
 * @property string $houseNumber
 * @property string $tel
 * @property string $fax
 * @property string $email
 * @property int $type_id
 * @property int $nature_id
 * @property int $industry_id
 * @property int $created_by
 * @property string $create_time
 * @property string $update_time
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('oldreferraldb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customerName', 'agencyHead', 'region_id', 'province_id', 'municipalityCity_id', 'houseNumber', 'tel', 'fax', 'email', 'type_id', 'nature_id', 'industry_id', 'created_by', 'create_time'], 'required'],
            [['region_id', 'province_id', 'municipalityCity_id', 'barangay_id', 'type_id', 'nature_id', 'industry_id', 'created_by'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['customerName', 'agencyHead'], 'string', 'max' => 250],
            [['houseNumber'], 'string', 'max' => 200],
            [['tel', 'fax', 'email'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customerName' => 'Customer Name',
            'agencyHead' => 'Agency Head',
            'region_id' => 'Region ID',
            'province_id' => 'Province ID',
            'municipalityCity_id' => 'Municipality City ID',
            'barangay_id' => 'Barangay ID',
            'houseNumber' => 'House Number',
            'tel' => 'Tel',
            'fax' => 'Fax',
            'email' => 'Email',
            'type_id' => 'Type ID',
            'nature_id' => 'Nature ID',
            'industry_id' => 'Industry ID',
            'created_by' => 'Created By',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
