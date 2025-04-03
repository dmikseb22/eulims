<?php

namespace common\models\services;

use common\models\lab\Lab;

use Yii;

/**
 * This is the model class for table "tbl_testcategory".
 *
 * @property int $testcategory_id
 * @property string $category_name
 * @property int $lab_id
 *
 * @property Packagelist[] $packagelists
 * @property Sampletype[] $sampletypes
 * @property Test[] $tests
 * @property Lab $lab
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
            [['category_name', 'lab_id'], 'required'],
            [['lab_id'], 'integer'],
            [['category_name'], 'string', 'max' => 200],
            [['lab_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lab::className(), 'targetAttribute' => ['lab_id' => 'lab_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'testcategory_id' => 'Testcategory ID',
            'category_name' => 'Category Name',
            'lab_id' => 'Lab ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackagelists()
    {
        return $this->hasMany(Packagelist::className(), ['testcategory_id' => 'testcategory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSampletypes()
    {
        return $this->hasMany(Sampletype::className(), ['testcategory_id' => 'testcategory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['testcategory_id' => 'testcategory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLab()
    {
        return $this->hasOne(Lab::className(), ['lab_id' => 'lab_id']);
    }
}
