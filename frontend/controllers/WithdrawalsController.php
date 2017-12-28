<?php

namespace yuncms\wallet\frontend\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yuncms\wallet\models\Wallet;
use yuncms\wallet\models\WalletWithdrawals;
use yuncms\wallet\frontend\models\WithdrawalsSearch;

/**
 * WithdrawalsController implements the CRUD actions for Withdrawals model.
 */
class WithdrawalsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create'],
                        'roles' => ['@']
                    ],
                ]
            ],
        ];
    }

    /**
     * Lists all WalletWithdrawals models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WithdrawalsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WalletWithdrawals model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WalletWithdrawals model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param string $currency
     * @return mixed
     */
    public function actionCreate($currency)
    {
        $model = new WalletWithdrawals();
        $model->currency = $currency;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $wallet = Wallet::find()->where(['user_id' => Yii::$app->user->id, 'currency' => $currency])->one();
            return $this->render('create', [
                'model' => $model,
                'currency' => $currency,
                'wallet' => $wallet
            ]);
        }
    }

    /**
     * Finds the WalletWithdrawals model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WalletWithdrawals the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WalletWithdrawals::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
