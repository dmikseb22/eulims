<?php

namespace common\models\lab;

use Yii;

/**
 * This is the model class for table "tbl_request_migration".
 *
 * @property int $request_id
 * @property string $request_ref_num
 * @property string $request_datetime
 * @property int $rstl_id
 * @property int $lab_id
 * @property int $customer_id
 * @property int $payment_type_id
 * @property string $modeofrelease_ids
 * @property string $discount
 * @property int $discount_id
 * @property int $purpose_id
 * @property string $total
 * @property string $report_due
 * @property string $conforme
 * @property string $receivedBy
 * @property int $created_at
 * @property int $posted
 * @property int $status_id
 * @property int $selected
 * @property int $other_fees_id
 * @property int $request_type_id
 * @property string $position
 * @property string $recommended_due_date
 * @property string $est_date_completion
 * @property string $items_receive_by
 * @property string $equipment_release_date
 * @property string $certificate_release_date
 * @property string $released_by
 * @property string $received_by
 * @property int $payment_status_id
 * @property int $request_old_id
 * @property string $oldColumn_requestId
 * @property int $oldColumn_sublabId
 * @property int $oldColumn_orId
 * @property double $oldColumn_completed
 * @property int $oldColumn_cancelled
 * @property string $oldColumn_create_time
 * @property int $customer_old_id
 * @property int $tmpCustomerID
 * @property int $is_migrated
 */
class RequestMigration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_request_migration';
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
            [['request_datetime', 'rstl_id', 'lab_id', 'customer_id', 'payment_type_id', 'modeofrelease_ids', 'discount_id', 'purpose_id', 'report_due', 'conforme', 'receivedBy', 'created_at'], 'required'],
            [['request_datetime', 'report_due', 'recommended_due_date', 'est_date_completion', 'equipment_release_date', 'certificate_release_date', 'oldColumn_create_time', 'request_old_id'], 'safe'],
            [['rstl_id', 'lab_id', 'customer_id', 'payment_type_id', 'discount_id', 'purpose_id', 'created_at', 'posted', 'status_id', 'selected', 'other_fees_id', 'request_type_id', 'payment_status_id', 'request_old_id', 'oldColumn_sublabId', 'oldColumn_orId', 'oldColumn_cancelled', 'customer_old_id', 'tmpCustomerID', 'is_migrated'], 'integer'],
            [['discount', 'total', 'oldColumn_completed'], 'number'],
            [['request_ref_num', 'modeofrelease_ids', 'conforme', 'receivedBy', 'oldColumn_requestId'], 'string', 'max' => 50],
            [['position', 'items_receive_by', 'released_by', 'received_by'], 'string', 'max' => 100],
            [['request_ref_num'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'request_id' => 'Request ID',
            'request_ref_num' => 'Request Ref Num',
            'request_datetime' => 'Request Datetime',
            'rstl_id' => 'Rstl ID',
            'lab_id' => 'Lab ID',
            'customer_id' => 'Customer ID',
            'payment_type_id' => 'Payment Type ID',
            'modeofrelease_ids' => 'Modeofrelease Ids',
            'discount' => 'Discount',
            'discount_id' => 'Discount ID',
            'purpose_id' => 'Purpose ID',
            'total' => 'Total',
            'report_due' => 'Report Due',
            'conforme' => 'Conforme',
            'receivedBy' => 'Received By',
            'created_at' => 'Created At',
            'posted' => 'Posted',
            'status_id' => 'Status ID',
            'selected' => 'Selected',
            'other_fees_id' => 'Other Fees ID',
            'request_type_id' => 'Request Type ID',
            'position' => 'Position',
            'recommended_due_date' => 'Recommended Due Date',
            'est_date_completion' => 'Est Date Completion',
            'items_receive_by' => 'Items Receive By',
            'equipment_release_date' => 'Equipment Release Date',
            'certificate_release_date' => 'Certificate Release Date',
            'released_by' => 'Released By',
            'received_by' => 'Received By',
            'payment_status_id' => 'Payment Status ID',
            'request_old_id' => 'Request Old ID',
            'oldColumn_requestId' => 'Old Column Request ID',
            'oldColumn_sublabId' => 'Old Column Sublab ID',
            'oldColumn_orId' => 'Old Column Or ID',
            'oldColumn_completed' => 'Old Column Completed',
            'oldColumn_cancelled' => 'Old Column Cancelled',
            'oldColumn_create_time' => 'Old Column Create Time',
            'customer_old_id' => 'Customer Old ID',
            'tmpCustomerID' => 'Tmp Customer ID',
            'is_migrated' => 'Is Migrated',
        ];
    }
}
