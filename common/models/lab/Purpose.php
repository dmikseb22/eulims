<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_purpose".
 *
 * @property integer $purpose_id
 * @property string $name
 * @property integer $active
 *
 * @property Request[] $requests
 */
class Purpose extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_purpose';
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
            [['name'], 'required'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'purpose_id' => 'Purpose ID',
            'name' => 'Name',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['purpose_id' => 'purpose_id']);
    }
}
