<?php

namespace yuncms\wallet\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
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
     * 定义行为
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::className()
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
            [['currency'], 'required'],
            [['money'], 'number'],
            [['currency'], 'string', 'max' => 10],
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
