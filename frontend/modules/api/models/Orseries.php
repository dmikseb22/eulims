<?php
namespace api\modules\v1\models;
use Yii;

/**
 * This is the model class for table "tbl_orseries".
 *
 * @property int $or_series_id
 * @property int $or_category_id
 * @property int $terminal_id
 * @property int $rstl_id
 * @property string $or_series_name
 * @property int $startor
 * @property int $nextor
 * @property int $endor
 *
 * @property Deposit[] $deposits 
 * @property Orcategory $orCategory
 */
class Orseries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_orseries';
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
            [['or_category_id', 'terminal_id', 'rstl_id', 'or_series_name', 'startor', 'nextor', 'endor'], 'required'],
            [['or_category_id', 'terminal_id', 'rstl_id', 'startor', 'nextor', 'endor'], 'integer'],
            [['or_series_name'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'or_series_id' => 'Or Series ID',
            'or_category_id' => 'Or Category ID',
            'terminal_id' => 'Terminal ID',
            'rstl_id' => 'Rstl ID',
            'or_series_name' => 'Or Series Name',
            'startor' => 'Startor',
            'nextor' => 'Nextor',
            'endor' => 'Endor',
        ];
    }

    
  
    /**
    * @return \yii\db\ActiveQuery
    */
   public function getDeposits() 
   { 
       return $this->hasMany(Deposit::className(), ['or_series_id' => 'or_series_id']); 
   } 
}
