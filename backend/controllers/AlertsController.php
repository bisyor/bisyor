<?php

namespace backend\controllers;

use backend\models\users\RoleMethods;
use Yii;
use backend\models\alerts\Alerts;
use backend\models\alerts\AlertsSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\references\Lang;

/**
 * AlertsController implements the CRUD actions for Alerts model.
 */
class AlertsController extends Controller
{
    /**
     * {@inheritdoc}
     */
  public function behaviors()
    {
        return [
          'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }


    /**
     * shu controllrga tegishli ruxsatlarni tekshirish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $alerts = RoleMethods::getAccess($roles, 'alerts', 'alerts');
        $listing = RoleMethods::getAccess($roles, 'alerts', 'alerts-listing');
        $edit = RoleMethods::getAccess($roles, 'alerts', 'alerts-edit');

        if ($alerts && $listing && $edit) {
            if ($action->id != null)
                throw new HttpException(405, 'У вас нет разрешения на доступ к этому действию.');
        }

        if ($listing) {
            if ($action->id == 'index' || $action->id == 'view')
                throw new HttpException(405, 'У вас нет разрешения на доступ к этому действию.');
        }

        if ($edit) {
            if ($action->id == 'create' || $action->id == 'update' || $action->id == 'delete')
                throw new HttpException(405, 'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * Lists all Alerts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $types = Alerts::TYPE_ALERTS;
        $searchModel = new AlertsSearch();
        $request = Yii::$app->request;

        foreach ($types as $key => $value) {
            $dataProviders[$key] = $searchModel->search($request->queryParams,$key);
        }

        $_COOKIE["tab-alerts"] = 'tab-item';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProviders' => $dataProviders,
            'types' => $types
        ]);
    }


    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     */
    public function actionUpdate($id)
    {
        $langs = Lang::getLanguages();
        $model = $this->findModel($id);

        $model->getTranslations($langs);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->SaveTranslates(Yii::$app->request->post(),$langs);
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
            'langs' => $langs
        ]);
    }

    public function actionChangeStatus()
    {
        $id = $_POST['id'];
        $model = Alerts::findOne($id);
        if($model->status == 0) {$model->status = 1;}
        else {$model->status = 0;}
        $model->save(false);
    }


    /**
     * @param $id
     * @return Alerts|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Alerts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
