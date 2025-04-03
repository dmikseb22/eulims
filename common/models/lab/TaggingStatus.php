<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_tagging_status".
 *
 * @property integer $tagging_status_id
 * @property string $tagging_status
 *
 * @property Tagging[] $taggings
 */
class TaggingStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_tagging_status';
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
            [['tagging_status'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tagging_status_id' => 'Tagging Status ID',
            'tagging_status' => 'Tagging Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaggings()
    {
        return $this->hasMany(Tagging::className(), ['tagging_status_id' => 'tagging_status_id']);
    }
}
