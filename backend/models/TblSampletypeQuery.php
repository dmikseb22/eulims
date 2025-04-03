<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TblSampletype]].
 *
 * @see TblSampletype
 */
class TblSampletypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TblSampletype[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TblSampletype|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
