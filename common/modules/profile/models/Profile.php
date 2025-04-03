<?php

namespace common\modules\profile\models;

use Yii;
use common\models\system\User;

/**
 * This is the model class for table "tbl_profile".
 *
 * @property integer $profile_id
 * @property integer $user_id
 * @property string $lastname
 * @property string $firstname
 * @property string $fullname
 * @property string $designation
 * @property string $middleinitial
 * @property string $contact_numbers
 * @property string $image_url
 * @property string $avatar
 *
 * @property User $user
 * @property Lab $lab
 * @property Rstl $rstl
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
    * @var mixed image the attribute for rendering the file input
    * widget for upload on the form
    */
    public $image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_profile';
    }
    public static function getDb()
    {
        return \Yii::$app->db;  
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lastname', 'firstname', 'designation'], 'required'],
            [['user_id'],'required','message'=>'Please select Username!'],
            [['user_id'], 'integer'],
            [['lastname', 'firstname', 'middleinitial','designation'], 'string', 'max' => 50],
            [['image_url','avatar','fullname','contact_numbers'], 'string', 'max' => 100],
            [['image'], 'safe'],
            [['image'], 'file', 'extensions'=>'jpg, gif, png'],
            ['user_id', 'unique', 'targetAttribute' => ['user_id'], 'message' => 'The Email has already been taken.'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']]
        ];
    }
    public function getImageFile() 
    {
        return isset($this->avatar) ? Yii::$app->params['uploadPath'] . $this->avatar : null;
    }

    /**
     * Returns avatar url or null if avatar is not set.
     * @param  int $size
     * @return string|null
     */
    public function getImageUrl()
    {
        $avatar = isset($this->avatar) ? $this->avatar : 'no-image.png';
        return $avatar;
        //return $ImageUrl;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User',
            'lastname' => 'Lastname',
            'firstname' => 'Firstname',
            'fullname' => 'FullName',
            'designation' => 'Designation',
            'middleinitial' => 'Middle Initial',
            'rstl_id' => 'RSTL',
            'lab_id' => 'Lab',
            'contact_numbers' => 'Contact #',
            'image_url'=>'Image',
            'avatar'=>'Avatar',
        ];
    }
    //public function getFullname(){
    //    return $this->firstname. ' ' . $this->lastname;
    //}
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }
    public function initialPreviewConfig($urldel = ['/controller/action-delete-files'])
    {

      $return_json = [];
      foreach ($this->initialPreviewConfig as $k => $url) {

        $parts=pathinfo($url);
        $name  =  $parts['basename'];
        $return_json[] = [
          'caption'=>$name,
          'width'=> '100px',
          // 'url'=> \yii\helpers\Url::to($urldel),
          'key'=>$k,
          'extra'=>['id'=>$k]
        ];

      }

      return $return_json;
    }
  
}
