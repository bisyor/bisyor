<?php

namespace backend\controllers\references;

use backend\models\references\Subscribers;
use Yii;
use backend\models\references\Contacts;
use backend\models\searchs\ContactsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\HttpException;  
use backend\models\polls\ContactsItem;
use backend\models\users\RoleMethods;

/**
 * ContactsController implements the CRUD actions for Contacts model.
 */
class ContactsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
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
     * shu controllerga tegishli ruxsatlarni tekshirish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
     public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $contacts = RoleMethods::getAccess($roles , 'contacts', 'contacts');
        $manage = RoleMethods::getAccess($roles , 'contacts', 'manage');
       
        if($contacts && $manage)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($manage)
        {   
            if($action->id =='delete' || $action->id =='update' || $action->id =='create')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * contact listini olish
     * @return string
     */
    public function actionIndex()
    {    
        $searchModel = new ContactsSearch();
        $firstDataProvider = $searchModel->search(Yii::$app->request->queryParams, 1);
        $secondDataProvider = $searchModel->search(Yii::$app->request->queryParams, 2);
        $sentenceDataProvider = $searchModel->search(Yii::$app->request->queryParams, 3);
        $thirdDataProvider = $searchModel->search(Yii::$app->request->queryParams, 4);
        $allDataProvider = $searchModel->search(Yii::$app->request->queryParams);

//        echo '<pre>';
//        print_r(Yii::$app->request->queryParams); die;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'firstDataProvider' => $firstDataProvider,
            'secondDataProvider' => $secondDataProvider,
            'sentenceDataProvider' => $sentenceDataProvider,
            'thirdDataProvider' => $thirdDataProvider, 
            'allDataProvider' => $allDataProvider,
        ]);
    }


    /**
     * Displays a single Contacts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Контакты",
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }


    /**
     * Delete an existing Contacts model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->redirect(['/references/contacts/index']);
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }


    /**
     * @return array|Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->redirect(['/references/contacts/index']);
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    public function actionCheck($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                $model->viewed = 1;
                $model->save(false);
                return $this->redirect(['/references/contacts/index']);
            }else{
                return [
                    'title'=> "Контакты",
                    'content'=>$this->renderAjax('reason', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                        Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }


    public function actionSetTab($tab, $value)
    {
        $session = Yii::$app->session;
        $session[$tab] = $value;
    }


    /**
     * Finds the Contacts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contacts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contacts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }
}
