<?php
namespace backend\controllers\references;

use Yii;
use backend\models\polls\Polls;
use backend\models\searchs\PollsSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use backend\models\polls\PollsItem;
use backend\models\polls\PollsIntegration;
use backend\models\users\RoleMethods;


class PollsController extends Controller
{
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
     * shu controllerga tegilishli  ruxsatlarni tekshirish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {   

        $roles = RoleMethods::getUsersRole();
        $polls = RoleMethods::getAccess($roles , 'polls', 'polls');
        $listing = RoleMethods::getAccess($roles , 'polls', 'polls-listing');
        $edit = RoleMethods::getAccess($roles , 'polls', 'polls-edit');

        if($polls && $listing && $edit)
        {
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($listing)
        {
            if($action->id =='index' || $action->id =='view')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($edit)
        {
            if($action->id =='create' || $action->id =='update' || $action->id == 'delete')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);

    }


    /**
     * pollarni lisiti
     * @return string
     */
    public function actionIndex()
    {       
        $searchModel = new PollsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'');
        $activeProvider = $searchModel->search(Yii::$app->request->queryParams,1);
        $chernovekProvider = $searchModel->search(Yii::$app->request->queryParams,2);
        $completedProvider = $searchModel->search(Yii::$app->request->queryParams,3);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'activeProvider' => $activeProvider,
            'chernovekProvider' => $chernovekProvider,
            'completedProvider' => $completedProvider,
        ]);
    }


    /**
     * sessionga qiymat yuklash
     * @param $tab
     * @param $value
     */
    public function actionSetTab($tab, $value)
    {
        $session = Yii::$app->session;
        $session[$tab] = $value;
    }


    /**
     * poll sozdat qilish
     * @return string|Response
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Polls(); 
        $values = [];
        $values [] = ""; 
        
        if ($model->load($request->post()) && $model->save()) {
            $integration = new PollsIntegration();
            $integration->poll_id = $model->id;
            $integration->language_id = 1;
            $integration->save();

            if(isset($_POST['names']))
            {
                foreach ($_POST['names'] as $key => $value) {
                    $polls_item =  new PollsItem();
                    $polls_item->poll_id = $model->id;
                    $polls_item->title = $value;
                    $polls_item->sorting = $key;
                    $polls_item->save();
                }
            }
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            if(isset($_POST['names'])) $values = $_POST['names']; 
            return $this->render('create', [
                'model' => $model,
                'values'=>$values,
            ]);
        }
    }


    /**
     * poll update qilish
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $values = [];
        $polls_item = PollsItem::find()->where(['poll_id'=>$model->id])->orderBy(['sorting'=>SORT_ASC])->all();
                foreach ($polls_item as $item) {
            $values [$item->id] = $item->title;
        }
            if ($model->load($request->post()) && $model->save()) {
            if(isset($_POST['names']))
            {   
                $i = 1;
                foreach ($_POST['names'] as $key => $value) {
                    $polls_item =  PollsItem::findOne($key);
                    if($polls_item != null){
                        $polls_item->title = $value;
                        $polls_item->sorting = $i;
                        $polls_item->save();
                    }
                    else {
                        $polls_new =  new PollsItem();
                        $polls_new->poll_id = $model->id;
                        $polls_new->title = $value;
                        $polls_new->sorting = $i;
                        $polls_new->save();
                    }
                $i++;
                }
            }
                return $this->redirect(['update', 'id' => $model->id]);
            }else{
                return $this->render('update', [
                    'model' => $model,
                    'values' => $values,
                ]);
            }
    }


    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionIntegration($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $values = [];
        $polls_item = PollsItem::find()->where(['poll_id'=>$model->id])->orderBy(['sorting'=>SORT_ASC])->all();
                foreach ($polls_item as $item) {
           $values [$item->id] = $item->title;
        }
        $integration = PollsIntegration::find()->where(['poll_id'=>$model->id])->one();
       
            if ($integration->load($request->post()) && $integration->save()) {
                 return $this->render('update', [
                    'model' => $model,
                    'values' => $values,
                ]);
            }
            else {
                return $this->redirect(['update', 'id' => $model->id]);
            }
    }


    /**
     * @param $id
     * @return array|Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
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
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = Polls::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
