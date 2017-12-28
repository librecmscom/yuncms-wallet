<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
/*
 * @var $this  yii\web\View
 * @var $form  yii\widgets\ActiveForm
 * @var $model yuncms\user\models\SettingsForm
 */
$this->title = Yii::t('wallet', 'Wallet Manage');
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="row">
        <div class="col-md-2">
            <?= $this->render('@yuncms/user/frontend/views/_profile_menu') ?>
        </div>
        <div class="col-md-10">
            <h2 class="h3 profile-title">
                <?= Yii::t('wallet', 'Wallets') ?>
                <div class="pull-right">
                    <a class="btn btn-primary" href="<?= Url::to(['/wallet/withdrawals/index']); ?>"
                    ><?= Yii::t('wallet', 'Withdrawals'); ?></a>
                    <a class="btn btn-primary"
                       href="<?= Url::to(['/wallet/wallet/index']); ?>"><?= Yii::t('wallet', 'Wallet'); ?></a>
                </div>
            </h2>
            <div class="row">
                <div class="col-md-12">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}\n{pager}",
                        'columns' => [
                            'currency',
                            'money',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => Yii::t('wallet', 'Operation'),
                                'template' => '{recharge}',
                                'buttons' => [
                                    'recharge' =>
                                        function ($url, $model, $key) {
                                            return '<a href="#" onclick="jQuery(\'#payment-currency\').val(\'' . $model->currency . '\');" data-toggle="modal"
                                                 data-target="#recharge_modal">' . Yii::t('wallet', 'Recharge') . '</a>   ' .
                                                Html::a(Yii::t('wallet', 'Withdrawals'), Url::to(['/wallet/withdrawals/create', 'currency' => $model->currency]));
                                        }]],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal
    ================================================== -->
<?php
if (Yii::$app->hasModule('trade')):
    $gateways = [];
    foreach (Yii::$app->payment->components as $id=>$component) {
        $component= Yii::$app->payment->get($id);

        $gateways[$component->id] = $component->title;
    }

    $payment = new \yuncms\trade\models\Trade();
    $form = ActiveForm::begin([
        'action' => Url::toRoute(['/trade/trade/create']),
    ]); ?>
    <?= Html::activeInput('hidden', $payment, 'currency', ['value' => '']) ?>
    <?= Html::activeInput('hidden', $payment, 'type', ['value' => '3']) ?>
    <?php Modal::begin([
    'options' => ['id' => 'recharge_modal'],
    'header' => Yii::t('wallet', 'Recharge'),
    'footer' => Html::button(Yii::t('wallet', 'Clean'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) . Html::submitButton(Yii::t('wallet', 'Submit'), ['class' => 'btn btn-primary']),
]); ?>
    <?= $form->field($payment, 'total_amount'); ?>
    <?= $form->field($payment, 'gateway')->inline(true)->radioList($gateways); ?>
    <?php
    Modal::end();
    ActiveForm::end();
endif;
?>