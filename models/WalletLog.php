<?php

namespace yuncms\wallet\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%wallet_log}}".
 *
 * @property int $id ID
 * @property int $wallet_id Wallet Id
 * @property int $type Type
 * @property string $money money
 * @property string $action Action
 * @property string $msg Msg
 * @property int $created_at Created At
 *
 * @property Wallet $wallet
 */
class WalletLog extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wallet_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wallet_id', 'type', 'created_at'], 'integer'],
            [['money'], 'number'],
            [['created_at'], 'required'],
            [['action'], 'string', 'max' => 50],
            [['msg'], 'string', 'max' => 255],
            [['wallet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Wallet::className(), 'targetAttribute' => ['wallet_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('wallet', 'ID'),
            'wallet_id' => Yii::t('wallet', 'Wallet Id'),
            'type' => Yii::t('wallet', 'Type'),
            'money' => Yii::t('wallet', 'money'),
            'action' => Yii::t('wallet', 'Action'),
            'msg' => Yii::t('wallet', 'Msg'),
            'created_at' => Yii::t('wallet', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWallet()
    {
        return $this->hasOne(Wallet::className(), ['id' => 'wallet_id']);
    }

    /**
     * @inheritdoc
     * @return WalletLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WalletLogQuery(get_called_class());
    }
}
