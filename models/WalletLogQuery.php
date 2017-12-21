<?php

namespace yuncms\wallet\models;

/**
 * This is the ActiveQuery class for [[WalletLog]].
 *
 * @see WalletLog
 */
class WalletLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return WalletLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return WalletLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
