<?php

namespace common\models\lab;

use Yii;
use linslin\yii2\curl;

/**
 * This is the model class for table "tbl_testname_method".
 *
 * @property int $testname_method_id
 * @property int $testname_id
 * @property int $method_id
 * @property string $create_time
 * @property string $update_time
 * @property int $lab_id
 * @property int $sampletype_id
 *
 * @property Testname $testname
 */
class Testnamemethod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_testname_method';
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
            [['testname_id', 'method_id', 'lab_id', 'sampletype_id'], 'required'],
            [['testname_id', 'method_id', 'lab_id', 'sampletype_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['testname_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testname::className(), 'targetAttribute' => ['testname_id' => 'testname_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'testname_method_id' => 'Testname Method ID',
            'testname_id' => 'Test Name',
            'method_id' => 'Method',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'lab_id' => 'Lab ID',
            'sampletype_id'=> 'Sampletype',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestname()
    {
        return $this->hasOne(Testname::className(), ['testname_id' => 'testname_id']);
    }

    public function getMethod()
    {
        return $this->hasOne(Methodreference::className(), ['method_reference_id' => 'method_id']);
    }

    public function getLab()
    {
        return $this->hasOne(Lab::className(), ['lab_id' => 'lab_id']);
    }

    public function getSampletype()
    {
        return $this->hasOne(Sampletype::className(), ['sampletype_id' => 'sampletype_id']);
    }

    public static function checking($id){
        
        if(isset($_SESSION['usertoken'])){
            $token= 'Authorization: Bearer '.$_SESSION['usertoken'];
            $curl = new curl\Curl();
            $curl->setOption(CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $token]);
            $curl->setOption(CURLOPT_CONNECTTIMEOUT, 180);
            $curl->setOption(CURLOPT_TIMEOUT, 180);
            $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
            $response = $curl->setGetParams(['id' => Yii::$app->user->identity->profile->rstl_id.'-'.$id,])->get("https://eulims.onelab.ph/api/restpstc/checkmethod");

            return $response;
        }else{
            return '';
        }
    }
}
