<?php

namespace common\models\lab;

use Yii;
use common\models\system\Rstl;
/**
 * This is the model class for table "tbl_lab_manager".
 *
 * @property int $lab_manager_id
 * @property int $rstl_id
 * @property int $lab_id
 * @property int $user_id
 * @property int $updated_at
 *
 * @property Lab $lab
 * @property Lab $lab0
 * @property Rstl $rstl
 */
class LabManager extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_lab_manager';
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
            [['rstl_id', 'lab_id', 'user_id'], 'required'],
            [['rstl_id', 'lab_id', 'user_id', 'updated_at'], 'integer'],
            [['lab_id', 'user_id', 'rstl_id'], 'unique', 'targetAttribute' => ['lab_id', 'user_id', 'rstl_id']],
            [['lab_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lab::className(), 'targetAttribute' => ['lab_id' => 'lab_id']],
            [['lab_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lab::className(), 'targetAttribute' => ['lab_id' => 'lab_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lab_manager_id' => 'Lab Manager ID',
            'rstl_id' => 'Rstl',
            'lab_id' => 'Lab',
            'user_id' => 'User ID',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLab()
    {
        return $this->hasOne(Lab::className(), ['lab_id' => 'lab_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLab0()
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
}
