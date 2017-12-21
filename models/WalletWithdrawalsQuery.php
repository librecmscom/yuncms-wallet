<?php

namespace yuncms\wallet\models;

/**
 * This is the ActiveQuery class for [[WalletWithdrawals]].
 *
 * @see WalletWithdrawals
 */
class WalletWithdrawalsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return WalletWithdrawals[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return WalletWithdrawals|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
