<?php

namespace common\models\lab;

use Yii;
use common\models\lab\Request;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "tbl_batchtestreport".
 *
 * @property int $batchtestreport_id
 * @property string $testreport_ids
 * @property int $request_id
 * @property string $batch_date
 *
 * @property Request[] $request
 * @property Testreport[] $testreport
 */
class Batchtestreport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_batchtestreport';
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
            [['testreport_ids', 'request_id', 'batch_date'], 'required'],
            [['testreport_ids'], 'string'],
            [['request_id'], 'integer'],
            [['batch_date','request'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'batchtestreport_id' => 'Batchtestreport ID',
            'testreport_ids' => 'Testreport Ids',
            'request_id' => 'Request ID',
            'batch_date' => 'Batch Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['request_id' => 'request_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestreports()
    {
        // return $this->hasOne(Testreport::className(), ['testreport_id' => 'testreport_id']);
        $ids = explode(",", $this->testreport_ids);
        // $query = Testreport::findOne($ids);
        // $query = new \yii\db\Query;
        // $query
        //     ->select('*')
        //     ->from('eulims_lab.tbl_testreport')
        //     ->where(['eulims_lab.tbl_testreport.testreport_id' => $ids])->all();
        $query=Testreport::find()->where(['testreport_id'=>$ids]);
         return $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 'totalCount'=>10
        ]);
    }
}
