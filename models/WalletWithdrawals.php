<?php

namespace yuncms\wallet\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yuncms\user\models\User;

/**
 * This is the model class for table "{{%wallet_withdrawals}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $bankcard_id 银行卡关系
 * @property string $currency 币种
 * @property string $money
 * @property int $status 状态
 * @property int $confirmed_at
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 * @property WalletBankcard $bankcard
 */
class WalletWithdrawals extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wallet_withdrawals}}';
    }

    /**
     * 定义行为
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::className(),
        ];
        $behaviors['user'] = [
            'class' => BlameableBehavior::className(),
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['user_id']
            ],
        ];
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'bankcard_id', 'status', 'confirmed_at'], 'integer'],
            [['currency'], 'required'],
            [['money'], 'number'],
            [['currency'], 'string', 'max' => 10],
            [['bankcard_id'], 'exist', 'skipOnError' => true, 'targetClass' => WalletBankcard::className(), 'targetAttribute' => ['bankcard_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('wallet', 'ID'),
            'user_id' => Yii::t('wallet', 'User ID'),
            'bankcard_id' => Yii::t('wallet', '银行卡关系'),
            'currency' => Yii::t('wallet', '币种'),
            'money' => Yii::t('wallet', 'Money'),
            'status' => Yii::t('wallet', '状态'),
            'confirmed_at' => Yii::t('wallet', 'Confirmed At'),
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
    public function getBankcard()
    {
        return $this->hasOne(WalletBankcard::className(), ['id' => 'bankcard_id']);
    }

    /**
     * @inheritdoc
     * @return WalletWithdrawalsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WalletWithdrawalsQuery(get_called_class());
    }
}
