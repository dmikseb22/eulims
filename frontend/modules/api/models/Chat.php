<?php

namespace api\modules\v1\models;
use yii\db\ActiveRecord;
use Yii;

use api\modules\v1\models\Profile;
use api\modules\v1\models\User;

class Chat extends \yii\db\ActiveRecord

{

    /**

     * @inheritdoc

     */

    public static function tableName()
    {
        return 'tbl_chat';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('messagedb');
    }

    /**

     * @inheritdoc

     */

     public function rules()
    {
        return [
            [['sender_userid', 'message', 'status_id'], 'required'],
            [['sender_userid', 'reciever_userid', 'status_id', 'contact_id', 'group_id', 'convo_id'], 'integer'],
            [['message'], 'string'],
            [['timestamp'], 'safe'],
            [['chat_id'], 'unique'],
           
        ];
    }
    


 
    /**

     * @inheritdoc

     */

    public function attributeLabels()
    {
        return [
            'chat_id' => 'Chat ID',
            'sender_userid' => 'Sender Userid',
            'reciever_userid' => 'To:',
            'message' => 'Message',
            'timestamp' => 'Timestamp',
            'status_id' => 'Status ID',
            'contact_id' => 'Contact ID',
            'group_id' => 'Group ID',
        ];
    }

    public function fields()

    {

        return [

	   'chat_id',
		'sender_userid',
		'reciever_userid',
		'message',
		'timestamp',
		'status_id',
		'contact_id',
		'group_id',
        'group'=>function()
        {
            return $this->group;    
        },
        'subsidiary_customer'=>function()
        {
            return $this->subsidiaryCustomer;    
        },
        'status'=>function()
        {
            return $this->status;    
        },
        'contact'=>function()
        {
            return $this->contact;    
        },
        'chat_activity_details'=>function()
        {
            return $this->chatActivityDetails;    
        },
		'chat_attachments'=>function()
        {
            return $this->chatAttachments;    
        }
                
        ];

    }
	
	public function getGroup()
    {
        return $this->hasOne(GroupMember::className(), ['group_id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(ChatStatus::className(), ['status_id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasMany(Contacts::className(), ['contact_id' => 'contact_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatActivityDetails()
    {
        return $this->hasMany(ChatActivityDetails::className(), ['userid' => 'sender_userid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatAttachments()
    {
        return $this->hasMany(ChatAttachment::className(), ['uploadedby_userid' => 'sender_userid']);
    }
	
	public static function getPossibleRecipients()
    {
        $user = new Yii::$app->controller->module->userModelClass;
		$users = $user::find();
        $users->where(['!=', 'user_id', Yii::$app->user->id]);
        
        $users = $users->all();

        return $users;
    }
	
	 public function getProfile($userid){
        $profile= Profile::find()->where(['user_id'=> $userid])->one();
		return $profile;
    }
	
	public function getUser($userid){
        $user= User::find()->where(['user_id'=> $userid])->one();
		return $user;
    }
}