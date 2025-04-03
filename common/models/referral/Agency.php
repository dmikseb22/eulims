<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_agency".
 *
 * @property int $agency_id
 * @property int $region_id
 * @property string $country
 * @property string $region
 * @property string $province
 * @property string $city
 * @property string $name
 * @property string $code
 * @property string $description
 * @property string $website
 * @property string $contact
 * @property string $address
 * @property string $geo_location
 * @property int $activated
 */
class Agency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_agency';
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
            [['agency_id', 'region_id', 'country', 'region', 'province', 'city', 'name', 'code', 'description', 'website', 'contact', 'address', 'geo_location', 'activated'], 'required'],
            [['agency_id', 'region_id', 'activated'], 'integer'],
            [['description', 'contact', 'address'], 'string'],
            [['country', 'region', 'province', 'city'], 'string', 'max' => 255],
            [['name', 'website', 'geo_location'], 'string', 'max' => 256],
            [['code'], 'string', 'max' => 20],
            [['agency_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'agency_id' => 'Agency ID',
            'region_id' => 'Region ID',
            'country' => 'Country',
            'region' => 'Region',
            'province' => 'Province',
            'city' => 'City',
            'name' => 'Name',
            'code' => 'Code',
            'description' => 'Description',
            'website' => 'Website',
            'contact' => 'Contact',
            'address' => 'Address',
            'geo_location' => 'Geo Location',
            'activated' => 'Activated',
        ];
    }
}
