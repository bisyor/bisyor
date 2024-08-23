<?php

namespace backend\controllers\shops;

use backend\models\users\RoleMethods;
use Yii;
use backend\models\shops\ShopsSubscribers;
use backend\models\shops\ShopsSubscribersSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * ShopsSubscribersController реализует действия CRUD для ShopsSubscribers модель.
 */
class ShopsSubscribersController extends Controller
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
     * shu controllerga tegishli ruxsatlarni tekshirirsh
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $shops = RoleMethods::getAccess($roles , 'shops', 'shops');
        $shops_listing = RoleMethods::getAccess($roles , 'shops', 'shops-listing');
        $shops_edit = RoleMethods::getAccess($roles , 'shops', 'shops-edit');

        if($shops && $shops_listing && $shops_edit)
        {
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($shops_listing)
        {
            if($action->id =='index' || $action->id =='view' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($shops_edit)
        {
            if($action->id =='create' || $action->id =='update' || $action->id =='delete' || $action->id =='bulk-delete' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);

    }


    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Обновляет существующий ShopsSubscribers модель.
     * Для запроса ajax вернет объект json и для запроса не-ajax, если обновление выполнено успешно, браузер будет 
     * перенаправлен на страницу просмотра.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Процесс для ajax-запроса
            */
            Yii::$app->response->format = Response::FORMAT_JSON; 
            if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-subscribers-pjax',
                    'forceClose'=> true,
                ];    
            }else{
                 return [
                    'title'=> "Изменить",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }


    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Удалить существующий ShopsSubscribers модель.
     * Для запроса ajax вернет объект json и для запроса не-ajax, если удаление прошло успешно, браузер будет 
     * перенаправлен на страницу «index».
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-subscribers-pjax'];
        }else{
            return $this->redirect(['index']);
        }


    }


    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Находит модель ShopsSubscribers На основе значения ее первичного ключа.
     * Если модель не найдена, будет выдано исключение 404 HTTP.
     * @param integer $id
     * @return ShopsSubscribers загруженная модель
     * @throws NotFoundHttpException если модель не может быть найдена
     */
    protected function findModel($id)
    {
        if (($model = ShopsSubscribers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }
}
