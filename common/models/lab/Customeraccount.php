<?php

namespace common\models\lab;

use Yii;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "tbl_customeraccount".
 *
 * @property int $customeraccount_id
 * @property int $customer_id
 * @property string $password_hash
 * @property string $auth_key
 * @property int $status
 * @property string $lastlogin
 * @property string $verifycode 
 * @property int $created_at 
 * @property int $updated_at 
 *
 * @property Customer $customer
 */
class Customeraccount extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_customeraccount';
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
            [['customer_id'], 'required'],
            [['customer_id', 'status'], 'integer'],
            [['password_hash', 'auth_key'], 'string', 'max' => 300],
            [['lastlogin'], 'string', 'max' => 100],
            [['customer_id'], 'unique'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customeraccount_id' => 'Customeraccount ID',
            'customer_id' => 'Customer ID',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'status' => 'Status',
            'lastlogin' => 'Lastlogin',
            'verifycode' => 'Verifycode',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

        /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);
    }

     /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['customer_id' => $id, 'status' =>1]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = Customeraccount::find()->where(['customer_id'=>$token->getClaim('uid')])->one();
        if($user){
             return new static($user);
            // return true;
        }
        return null;
    }


    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

     /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

       /**
     * Finds User by Email
     * @param string $email
     */
    public static function findByCustomerid($customer_id){
        // return static::find()->where(['customer_id'=>$customer_id,'status'=> 1])->one();
        return static::find()->where(['customer_id'=>$customer_id,'status'=> 1])->one();
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->generateAuthKey();
            }
            return true;
        }
        return false;
    }

    
}
