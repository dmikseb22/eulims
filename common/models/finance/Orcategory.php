<?php

namespace common\models\finance;

use Yii;

/**
 * This is the model class for table "tbl_orcategory".
 *
 * @property int $or_category_id
 * @property string $category
 * @property string $category_code
 *
 * @property Orseries[] $orseries
 */
class Orcategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_orcategory';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('financedb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'category_code'], 'required'],
            [['category', 'category_code'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'or_category_id' => 'Or Category ID',
            'category' => 'Category',
            'category_code' => 'Category Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrseries()
    {
        return $this->hasMany(Orseries::className(), ['or_category_id' => 'or_category_id']);
    }
}
