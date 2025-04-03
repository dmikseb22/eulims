<?php

namespace common\models\inventory;

use Yii;

/**
 * This is the model class for table "tbl_categorytype".
 *
 * @property integer $categorytype_id
 * @property string $categorytype
 * @property string $description
 *
 * @property Products[] $products
 */
class Categorytype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_categorytype';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('inventorydb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categorytype'], 'required'],
            [['description'], 'string'],
            [['categorytype'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categorytype_id' => 'Categorytype ID',
            'categorytype' => 'Type',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['categorytype_id' => 'categorytype_id']);
    }
}
