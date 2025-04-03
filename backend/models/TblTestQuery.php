<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TblTest]].
 *
 * @see TblTest
 */
class TblTestQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TblTest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TblTest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
