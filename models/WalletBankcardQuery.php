<?php

namespace yuncms\wallet\models;

/**
 * This is the ActiveQuery class for [[WalletBankcard]].
 *
 * @see WalletBankcard
 */
class WalletBankcardQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return WalletBankcard[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return WalletBankcard|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
