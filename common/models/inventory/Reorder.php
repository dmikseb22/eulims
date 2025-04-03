<?php

namespace common\models\inventory;

use Yii;

/**
 * This is the model class for table "tbl_reorder".
 *
 * @property int $reorder_id
 * @property int $product_id
 * @property string $date_created
 * @property int $isaction
 *
 * @property Products $product
 */
class Reorder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_reorder';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('inventorydb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id', 'isaction'], 'integer'],
            [['date_created'], 'safe'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'product_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reorder_id' => 'Reorder ID',
            'product_id' => 'Product ID',
            'date_created' => 'Date Created',
            'isaction' => 'Isaction',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['product_id' => 'product_id']);
    }
}
