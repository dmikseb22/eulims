<?php

/**
 * This is the model class for table "notification".
 *
 * The followings are the available columns in table 'notification':
 * @property integer $id
 * @property integer $type_id
 * @property integer $recipient_id
 * @property integer $sender_id
 * @property string $sender
 * @property string $message
 * @property string $controller
 * @property string $action
 * @property integer $resource_id
 * @property integer $viewed
 * @property string $notificationDate
 */
namespace common\models\oldreferral;

use Yii;

class Notification extends \yii\db\ActiveRecord
{
    public $estimatedDueDate;
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'notification';
	}
	
	public static function getDb()
    {
        return Yii::$app->get('oldreferraldb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
	{
        /*
        $notification->sender = Users::model()->findByPk(Yii::app()->user->id)->fullname;
        $notification->recipient_id = $_POST['recipient_id'];
        $notification->sender_id = Yii::app()->getModule('user')->user()->profile->getAttribute('agency');
        $notification->resource_id = $_POST['resource_id'];
        $notification->viewed = 0;
        $notification->controller = 'referral';
        $notification->action = 'preview';
        */
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return[
			[['sender'], 'required'],
			[['type_id, recipient_id, sender_id, resource_id, viewed', 'numerical'], 'number'],
			[['sender'], 'string', 'max' => 50],
			[['message'], 'string', 'max'=>100],
			//['controller, action', 'length', 'max'=>15],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			[['id, type_id, recipient_id, sender_id, sender, message, controller, action, resource_id, viewed, notificationDate, estimatedDueDate'], 'safe'],
		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
            'referral'	=> [self::BELONGS_TO, 'Referral', 'resource_id'],
            'sentBy'	=> [self::BELONGS_TO, 'Agency', 'sender_id'],
            'sentTo'	=> [self::BELONGS_TO, 'Agency', 'recipient_id'],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'type_id' => 'Type',
			'recipient_id' => 'Recipient',
			'sender_id' => 'Sender',
			'sender' => 'Sender',
			'message' => 'Message',
			'controller' => 'Controller',
			'action' => 'Action',
			'resource_id' => 'Resource',
			'viewed' => 'Read',
            'estimatedDueDate' => 'Turnround Time',
			'notificationDate' => 'Notification Date',
		];
	}


}
