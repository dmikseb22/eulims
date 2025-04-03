<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "tbl_testcategory".
 *
 * @property integer $testcategory_id
 * @property string $category_name
 * @property integer $lab_id
 *
 * @property \app\models\Packagelist[] $packagelists
 * @property \app\models\Sampletype[] $sampletypes
 * @property \app\models\Test[] $tests
 * @property \app\models\Lab $lab
 */
class TblTestcategory extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct(){
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => \Yii::$app->user->id,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'packagelists',
            'sampletypes',
            'tests',
            'lab'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'lab_id'], 'required'],
            [['lab_id'], 'integer'],
            [['category_name'], 'string', 'max' => 200],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
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
     *
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock
     *
     */
    public function optimisticLock() {
        return 'lock';
    }

    /**
     * @inheritdoc
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
        return $this->hasMany(\app\models\Packagelist::className(), ['testcategory_id' => 'testcategory_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSampletypes()
    {
        return $this->hasMany(\app\models\Sampletype::className(), ['test_category_id' => 'testcategory_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(\app\models\Test::className(), ['test_category_id' => 'testcategory_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLab()
    {
        return $this->hasOne(\app\models\Lab::className(), ['lab_id' => 'lab_id']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'uuid' => [
                'class' => UUIDBehavior::className(),
                'column' => 'id',
            ],
        ];
    }

    /**
     * The following code shows how to apply a default condition for all queries:
     *
     * ```php
     * class Customer extends ActiveRecord
     * {
     *     public static function find()
     *     {
     *         return parent::find()->where(['deleted' => false]);
     *     }
     * }
     *
     * // Use andWhere()/orWhere() to apply the default condition
     * // SELECT FROM customer WHERE `deleted`=:deleted AND age>30
     * $customers = Customer::find()->andWhere('age>30')->all();
     *
     * // Use where() to ignore the default condition
     * // SELECT FROM customer WHERE age>30
     * $customers = Customer::find()->where('age>30')->all();
     * ```
     */

    /**
     * @inheritdoc
     * @return \app\models\TblTestcategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \app\models\TblTestcategoryQuery(get_called_class());
        return $query->where(['deleted_by' => 0]);
    }
}
