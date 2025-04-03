<?php

namespace common\models\inventory;

use Yii;

/**
 * This is the model class for table "tbl_producttype".
 *
 * @property integer $producttype_id
 * @property string $producttype
 *
 * @property Products[] $products
 */
class Producttype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_producttype';
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
            [['producttype'], 'required'],
            [['producttype'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'producttype_id' => 'Producttype ID',
            'producttype' => 'Producttype',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['producttype_id' => 'producttype_id']);
    }
}
