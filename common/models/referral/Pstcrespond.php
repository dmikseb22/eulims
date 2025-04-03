<?php

namespace common\models\referral;

use Yii;

/**
 * This is the model class for table "tbl_pstcrespond".
 *
 * @property int $pstc_respond_id
 * @property int $rstl_id
 * @property int $pstc_id
 * @property int $pstc_request_id
 * @property string $request_ref_num
 * @property int $local_request_id
 * @property string $request_date_created
 * @property string $estimated_due_date
 * @property int $lab_id
 * @property string $actionDate_old
 * @property int $status_old
 * @property string $created_at
 * @property string $updated_at
 */
class Pstcrespond extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_pstcrespond';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('referraldb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rstl_id', 'pstc_id', 'pstc_request_id', 'local_request_id', 'request_date_created', 'estimated_due_date', 'lab_id', 'status_old', 'created_at'], 'required'],
            [['rstl_id', 'pstc_id', 'pstc_request_id', 'local_request_id', 'lab_id', 'status_old'], 'integer'],
            [['request_date_created', 'estimated_due_date', 'actionDate_old', 'created_at', 'updated_at'], 'safe'],
            [['request_ref_num'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pstc_respond_id' => 'Pstc Respond ID',
            'rstl_id' => 'Rstl ID',
            'pstc_id' => 'Pstc ID',
            'pstc_request_id' => 'Pstc Request ID',
            'request_ref_num' => 'Request Ref Num',
            'local_request_id' => 'Local Request ID',
            'request_date_created' => 'Request Date Created',
            'estimated_due_date' => 'Estimated Due Date',
            'lab_id' => 'Lab ID',
            'actionDate_old' => 'Action Date Old',
            'status_old' => 'Status Old',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getRequest()
    {
        return $this->hasOne(Pstcrequest::className(), ['pstc_request_id' => 'pstc_request_id']);
    }
}
