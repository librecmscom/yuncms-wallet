<?php

namespace yuncms\wallet\models;

use Yii;
use yii\db\ActiveRecord;
use yuncms\user\models\User;

/**
 * This is the model class for table "{{%wallet_bankcard}}".
 *
 * @property int $id Id
 * @property int $user_id User Id
 * @property string $bank 银行名称
 * @property string $city 开户城市
 * @property string $username 开户名
 * @property string $name 开户行
 * @property string $number 银行卡号
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 * @property WalletWithdrawals[] $walletWithdrawals
 */
class WalletBankcard extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wallet_bankcard}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'required'],
            [['bank'], 'string', 'max' => 100],
            [['city', 'username', 'name'], 'string', 'max' => 50],
            [['number'], 'string', 'max' => 30],
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
            'bank' => Yii::t('wallet', '银行名称'),
            'city' => Yii::t('wallet', '开户城市'),
            'username' => Yii::t('wallet', '开户名'),
            'name' => Yii::t('wallet', '开户行'),
            'number' => Yii::t('wallet', '银行卡号'),
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
    public function getWalletWithdrawals()
    {
        return $this->hasMany(WalletWithdrawals::className(), ['bankcard_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return WalletBankcardQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WalletBankcardQuery(get_called_class());
    }
}
