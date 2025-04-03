<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_documentcontrol".
 *
 * @property int $documentcontrol_id
 * @property string $originator
 * @property string $date_requested
 * @property string $division
 * @property string $code_num
 * @property string $title
 * @property string $previous_rev_num
 * @property string $new_revision_no
 * @property string $pages_revised
 * @property string $effective_date
 * @property string $reason
 * @property string $description
 * @property string $reviewed_by
 * @property string $approved_by
 * @property string $dcf_no
 * @property string $custodian
 */
class Documentcontrol extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_documentcontrol';
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
            [['originator', 'date_requested', 'division', 'code_num', 'title', 'previous_rev_num', 'new_revision_no', 'pages_revised', 'effective_date', 'reason', 'description', 'reviewed_by', 'approved_by', 'dcf_no', 'custodian'], 'required'],
            [['date_requested', 'effective_date'], 'safe'],
            [['originator', 'division', 'code_num', 'title', 'previous_rev_num', 'new_revision_no', 'pages_revised', 'reason', 'description', 'reviewed_by', 'approved_by', 'dcf_no', 'custodian'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'documentcontrol_id' => 'Documentcontrol ID',
            'originator' => 'Originator',
            'date_requested' => 'Date Requested',
            'division' => 'Division',
            'code_num' => 'Code Num',
            'title' => 'Title',
            'previous_rev_num' => 'Previous Rev Num',
            'new_revision_no' => 'New Revision No',
            'pages_revised' => 'Pages Revised',
            'effective_date' => 'Effective Date',
            'reason' => 'Reason',
            'description' => 'Description',
            'reviewed_by' => 'Reviewed By',
            'approved_by' => 'Approved By',
            'dcf_no' => 'Dcf No',
            'custodian' => 'Custodian',
        ];
    }
}
