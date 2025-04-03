<?php


namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_testcategory".
 *
 * @property int $testcategory_id
 * @property string $category
 */
class Testcategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_testcategory';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('labdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category'], 'required'],
            [['category'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'testcategory_id' => 'Test Category',
            'category' => 'Category',
        ];
    }

   
}
