<?php

namespace api\modules\v1\models;
use yii\db\ActiveRecord;
use Yii;

class Profile extends \yii\db\ActiveRecord

{
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
            [['lastname', 'firstname', 'designation','rstl_id','lab_id'], 'required'],
            [['user_id'],'required','message'=>'Please select Username!'],
            [['user_id','rstl_id','lab_id'], 'integer'],
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
        //if($this->avatar==null || $this->avatar==''){
        //    $ImageUrl='no-image.png';
        //}else{
        //    $ImageUrl= $this->avatar;
        //}
        $func=new Functions();
        $avatar = isset($this->avatar) ? $this->avatar : 'no-image.png';
        $imgUrl=\Yii::$app->getModule("profile")->assetsUrl."/photo/$avatar";
        if(!$func->CheckUrlExist($imgUrl)){
            $avatar="image-not-found.png";
        }
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
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }
     public function getLab()
    {
        return $this->hasOne(Lab::className(), ['lab_id' => 'lab_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRstl()
    {
        return $this->hasOne(Rstl::className(), ['rstl_id' => 'rstl_id']);
    }

	public function fields()

    {

        return [

		'user_id',
		'lastname',
		'firstname',
		'fullname',
		'designation',
		'middleinitial',
		'rstl_id',
		'lab_id',
		'contact_numbers',
		'image_url',
		'avatar'
        'user'=>function()
        {
            return $this->user;    
        },
        'rstl'=>function()
        {
            return $this->rstl;    
        },
        'lab'=>function()
        {
            return $this->lab;    
        }
                
        ];

    }
	
}