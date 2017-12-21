<?php

namespace yuncms\wallet\backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\bootstrap\ActiveForm;
use yii\web\NotFoundHttpException;
use yuncms\wallet\models\WalletWithdrawals;
use yuncms\wallet\backend\models\WithdrawalsSearch;

/**
 * WithdrawalsController implements the CRUD actions for WalletWithdrawals model.
 */
class WithdrawalsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'confirm' => ['POST'],
                    'batch-delete' => ['POST'],
                    'rejected' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * rejected the WalletWithdrawals.
     *
     * @param int $id
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionRejected($id)
    {
        $model = $this->findModel($id);
        $model->setRejected();
        Yii::$app->getSession()->setFlash('success', Yii::t('wallet', 'Withdrawals has been rejected'));
        return $this->redirect(Url::previous('actions-redirect'));
    }

    /**
     * Confirms the WalletWithdrawals.
     *
     * @param int $id
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionConfirm($id)
    {
        $model = $this->findModel($id);
        $model->setDone();
        Yii::$app->getSession()->setFlash('success', Yii::t('wallet', 'Withdrawals has been confirmed'));
        return $this->redirect(Url::previous('actions-redirect'));
    }

    /**
     * Lists all WalletWithdrawals models.
     * @return mixed
     */
    public function actionIndex()
    {
        Url::remember('', 'actions-redirect');
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
        Url::remember('', 'actions-redirect');
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WalletWithdrawals model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Url::remember('', 'actions-redirect');
        $model = new WalletWithdrawals();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('wallet', 'Create success.'));
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WalletWithdrawals model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        Url::remember('', 'actions-redirect');
        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('wallet', 'Update success.'));
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WalletWithdrawals model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->getSession()->setFlash('success', Yii::t('wallet', 'Delete success.'));
        return $this->redirect(['index']);
    }

    /**
     * Batch Delete existing WalletWithdrawals model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionBatchDelete()
    {
        if (($ids = Yii::$app->request->post('ids', null)) != null) {
            foreach ($ids as $id) {
                $model = $this->findModel($id);
                $model->delete();
            }
            Yii::$app->getSession()->setFlash('success', Yii::t('wallet', 'Delete success.'));
        } else {
            Yii::$app->getSession()->setFlash('success', Yii::t('wallet', 'Delete failed.'));
        }
        return $this->redirect(['index']);
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
            throw new NotFoundHttpException (Yii::t('yii', 'The requested page does not exist.'));
        }
    }
}
