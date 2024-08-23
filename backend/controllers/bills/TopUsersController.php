<?php

namespace backend\controllers\bills;

use Yii;
use backend\models\bills\Bills;
use backend\models\users\Users;
use backend\models\bills\BillsSearch;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\Response;


class TopUsersController extends Controller
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
        ];
    }


    public function actionIndex()
    {
        $request = Yii::$app->request;
        $post = $request->post();

//        echo '<pre>';
//        print_r($post); die;

        $searchModel = new BillsSearch();
        $dataProvider = $searchModel->topUserBills($request->queryParams,$post);
        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'post' => $post,
        ]);
    }

    public function actionUserInfo($id)
    {
        $user = Users::find()->where(['id' => $id])->one();
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> "<p class='text-center'><b>Информация о пользователе</b></p>",
                'size' => 'large',
                'content'=>$this->renderAjax('user-info', [
                    'model' => $user,
                ]),
                'footer'=> Html::button('Закрыть',['class'=>'btn btn-sm btn-inverse pull-left','data-dismiss'=>"modal"]).
                    Html::a('Редактировать #' . $user->id,['/users/users/edit-info','id'=>$user->id],['class'=>'btn btn-sm btn-primary','data-pjax' => 0])
            ];
        }else{
            return $this->render('user-info', [
                'model' => $user,
            ]);
        }
    }



    protected function findModel($id)
    {
        if (($model = Bills::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }
}
