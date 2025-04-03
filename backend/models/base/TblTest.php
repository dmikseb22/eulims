<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "tbl_test".
 *
 * @property integer $test_id
 * @property integer $agency_id
 * @property string $testname
 * @property string $method
 * @property string $references
 * @property string $fee
 * @property integer $duration
 * @property integer $test_category_id
 * @property integer $sample_type_id
 * @property integer $lab_id
 *
 * @property \app\models\Analysis[] $analyses
 * @property \app\models\Lab $lab
 * @property \app\models\Testcategory $testCategory
 * @property \app\models\Sampletype $sampleType
 */
class TblTest extends \yii\db\ActiveRecord
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
            'analyses',
            'lab',
            'testCategory',
            'sampleType'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agency_id', 'testname', 'method', 'references', 'duration', 'test_category_id', 'sample_type_id', 'lab_id'], 'required'],
            [['agency_id', 'duration', 'test_category_id', 'sample_type_id', 'lab_id'], 'integer'],
            [['fee'], 'number'],
            [['testname'], 'string', 'max' => 200],
            [['method'], 'string', 'max' => 150],
            [['references'], 'string', 'max' => 100],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_test';
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
            'test_id' => 'Test ID',
            'agency_id' => 'Agency ID',
            'testname' => 'Testname',
            'method' => 'Method',
            'references' => 'References',
            'fee' => 'Fee',
            'duration' => 'Duration',
            'test_category_id' => 'Test Category ID',
            'sample_type_id' => 'Sample Type ID',
            'lab_id' => 'Lab ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnalyses()
    {
        return $this->hasMany(\app\models\Analysis::className(), ['test_id' => 'test_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLab()
    {
        return $this->hasOne(\app\models\Lab::className(), ['lab_id' => 'lab_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestCategory()
    {
        return $this->hasOne(\app\models\Testcategory::className(), ['testcategory_id' => 'test_category_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSampleType()
    {
        return $this->hasOne(\app\models\Sampletype::className(), ['sample_type_id' => 'sample_type_id']);
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
     * @return \app\models\TblTestQuery the active query used by this AR class.
     */
    public static function find()
    {
        $query = new \app\models\TblTestQuery(get_called_class());
        return $query->where(['deleted_by' => 0]);
    }
}
