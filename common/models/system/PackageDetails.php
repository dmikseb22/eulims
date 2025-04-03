<?php

namespace common\models\system;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\components\RBAC;
/********* DO NOT RECREATE PackageDetails in order not to override custom events ********************************/
/**
 * This is the model class for table "tbl_package_details".
 *
 * @property integer $Package_DetailID
 * @property integer $PackageID
 * @property string $Package_Detail
 * @property string $url
 * @property string $icon
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Package $package
 */
class PackageDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_package_details';
    }
     /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * 
     * @param type $insert
     * @param type $changedAttributes
     */
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
         if ($insert) { // Insert command
             $RBAC=new RBAC();
             $SubModuleName= $this->Package_Detail;
             $Url= $this->url;
             $RBAC->CreateSubModulePermissions($SubModuleName, $Url);
         }
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PackageID', 'Package_Detail'], 'required'],
            [['PackageID', 'created_at', 'updated_at'], 'integer'],
            [['Package_Detail', 'icon'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 200],
            [['Package_Detail'], 'unique'],
            [['PackageID'], 'exist', 'skipOnError' => true, 'targetClass' => Package::className(), 'targetAttribute' => ['PackageID' => 'PackageID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Package_DetailID' => 'Package  Detail ID',
            'PackageID' => 'Package ID',
            'Package_Detail' => 'Package  Detail',
            'url' => 'Url',
            'icon' => 'Icon',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['PackageID' => 'PackageID']);
    }
}
