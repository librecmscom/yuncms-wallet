<?php

namespace yuncms\wallet\models;

use Yii;
use yii\db\ActiveRecord;
use yuncms\user\models\User;

/**
 * This is the model class for table "{{%wallet}}".
 *
 * @property int $id Id
 * @property int $user_id User Id
 * @property string $currency Currency
 * @property string $money
 * @property int $created_at Created At
 * @property int $updated_at Updated At
 *
 * @property User $user
 * @property WalletLog[] $walletLogs
 */
class Wallet extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wallet}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'currency', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['money'], 'number'],
            [['currency'], 'string', 'max' => 10],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('wallet', 'Id'),
            'user_id' => Yii::t('wallet', 'User Id'),
            'currency' => Yii::t('wallet', 'Currency'),
            'money' => Yii::t('wallet', 'Money'),
            'created_at' => Yii::t('wallet', 'Created At'),
            'updated_at' => Yii::t('wallet', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(WalletLog::className(), ['wallet_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return WalletQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WalletQuery(get_called_class());
    }
}
