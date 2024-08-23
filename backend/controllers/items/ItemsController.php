<?php

namespace backend\controllers\items;

use backend\models\chats\ChatUsers;
use backend\models\items\ItemsBloked;
use backend\models\items\ItemsScale;
use Yii;
use backend\models\items\Items;
use backend\models\items\Categories;
use backend\models\items\ItemsClaim;
use backend\models\items\ItemsImages;
use backend\models\references\Lang;
use backend\models\items\ItemsClaimSearch;
use backend\models\items\ItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \yii\web\Response;
use yii\helpers\Html;
use backend\models\users\RoleMethods;
use yii\web\HttpException;

/**
 * ItemsController реализует действия CRUD для Items модель.
 */
class ItemsController extends Controller
{

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
                    'bulk-block' => ['post'],
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
        $bbs = RoleMethods::getAccess($roles , 'bbs', 'bbs');
        $items_listing = RoleMethods::getAccess($roles , 'bbs', 'items-listing');
        $items_edit = RoleMethods::getAccess($roles , 'bbs', 'items-edit');
        $items_moderate = RoleMethods::getAccess($roles , 'bbs', 'items-moderate');
       
        
        if($bbs && $items_listing && $items_edit && $items_moderate)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($items_edit)
        {

            if($action->id =='create' || $action->id =='update' || $action->id =='delete')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($items_listing)
        {   
            if($action->id =='view' || $action->id =='index' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($items_moderate)
        {
            if($action->id =='bulk-change-status' || $action->id =='change-status' || $action->id =='block-item')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if (in_array($action->id, ['search'])) {
            $this->enableCsrfValidation = false;
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);

    }


    /**
     * elonlar lisitini  olish
     * @param null $user_id
     * @return string
     */
    public function actionIndex($user_id = null)
    {    
        $statuses = Items::STATUS_TYPE;
        $request = Yii::$app->request;
        if($user_id){
            Yii::$app->request->setQueryParams( [
                'ItemsSearch' => [
                    'user_id' => $user_id
                ],
            ] );
            $user_id = null;
        }

        $searchModel = new ItemsSearch();
        $itemsCountModeration = Items::find()->where(['is_moderating' => 1])->andFilterWhere(['user_id' => $user_id])->count();

        foreach ($statuses as $key => $value) {
            if(isset($value['statuses']))
                $dataProviders[$key] = $searchModel->search($request->queryParams,$value['statuses']);
            else
                $dataProviders[$key] = $searchModel->search($request->queryParams);
        }

        $_COOKIE["tab-items"] = 'tab-0';

        return $this->render('index', [
            'itemsCountModeration' => $itemsCountModeration,
            'searchModel' => $searchModel,
            'dataProviders' => $dataProviders,
            'statuses' => $statuses
        ]);
    }


    public function actionTest($text)
    {
        echo '<pre>';
        print_r(Items::find()->where(['like' , 'description', $text])->count());
        die;
    }

    /**
     * ayni bir e'lonni korish
     * @param $id
     * @return array|string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $user_id = Yii::$app->user->identity->id;
        $model = $this->findModel($id);
        $chats_count = ChatUsers::find()
            ->andWhere(['item_id'=>$model->id])
            ->andWhere(['!=','user_id' ,$model->user_id])
            ->count();
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "<p class='text-center'>Информация об объявлении № ".$id ."</p>",
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                        'chats_count' => $chats_count,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                            Html::a('Изменить',['update','id'=>$id],['class'=>'btn btn-primary','data-pjax'=>'0'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
                'chats_count' => $chats_count,
            ]);
        }
    }


    /**
     * elonni statusni ozgartirish
     * @param $id
     * @param $status
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionChangeStatusItem($id,$status)
    {
        $statuses = Items::STATUS_TYPE;
        $user_id = Yii::$app->user->identity->id;
        $model = $this->findModel($id);
        $request = Yii::$app->request;
        $tab = isset($_COOKIE["tab-items"]) && $_COOKIE["tab-items"] != 'undefined' ? $_COOKIE["tab-items"] : 'tab-1';
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->blocked_reason == 'Заблокировано навсегда') $status = 5;
            $model->changeStatusTo($status);
            if($status == 0){
                $model->setRassilkaActivateItems();
                ItemsScale::setBallItems($model);
                Yii::$app->db->createCommand()->update(
                    'items', ['moderated_id' => $user_id,'moderation_date' =>date('Y-m-d H:i:s')], [ 'id' => $model->id ])
                    ->execute();
            }
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-items-'.$tab];
        }
    }


    /**
     * elonlarni bloklash
     * @param $id
     * @param $status
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionBlockItem($id,$status)
    {
        $request = Yii::$app->request;

        $model = $this->findModel($id);
        $model->blocking = true;

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->load($request->post()) && ($model->validate() || $model->blocked_status)){
                $model->changeStatusTo($status);
                $model->save(false);
               return $this->redirect(['/items/items/update',
                   'id'=> $id
               ]);
            }else{
                return [
                    'title'=> "<p class='text-center'><b>Заблокировать</b></p>",
                    'content'=>$this->renderAjax('block-form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-sm btn-inverse pull-left','data-dismiss'=>"modal"]).Html::button('заблокировать',['class'=>'btn btn-danger','type'=>"submit"])
                ];  
            }
        }
    }

    public function actionBulkBlockItem($status)
    {
        $request = Yii::$app->request;
        $model = new ItemsBloked();
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->load($request->post()) && $model->validate()){
                $model->ids = explode(',', $model->ids);
                $model->blockedItemsList();
                $tab = isset($_COOKIE["tab-items"]) && $_COOKIE["tab-items"] != 'undefined' ? $_COOKIE["tab-items"] : 'tab-1';
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-items-'.$tab];
            }else{
                $pks = explode(',', $request->post( 'pks' ));
                $model->ids = $pks;
                return [
                        'title'     => "<p class='text-center'><b>Заблокировать</b></p>",
                        'content'   => $this->renderAjax('bulk-block', [
                        'model'     => $model,
                        'pks'       => $pks,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-sm btn-inverse pull-left','data-dismiss'=>"modal"]).Html::button('заблокировать',['class'=>'btn btn-danger','type'=>"submit"])
                ];
            }
        }
    }


    /**
     * elonlarni statusni ozgartitish
     * @param $id
     * @param $status
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionChangeStatus($id,$status)
    {
        $model = $this->findModel($id);
        $user_id = Yii::$app->user->identity->id;
        $request = Yii::$app->request;
        $model->changeStatusTo($status);
        if($status == 0){
            $model->setRassilkaActivateItems();
            ItemsScale::setBallItems($model);
            Yii::$app->db->createCommand()->update(
                'items', ['moderated_id' => $user_id,'moderation_date' =>date('Y-m-d H:i:s')], [ 'id' => $model->id ])
                ->execute();
        }
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }
    }


    public function actionChangeBlockedReason($value,$id)
    {
        $model = $this->findModel($id);
        $model->blocked_reason = $value;
        $model->save(false);
        return $model->blocked_reason;
    }


    /**
     * additional field larni chiqrish category on change da ishlaydi
     * @param $category_id
     * @param int $model_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShowAdditionalFields($category_id,$model_id = -1)
    {
        $langs = Lang::getLanguages();
        $category = Categories::findOne($category_id);
        $category->getPriceSett($langs);
        $fields = $category->getAdditionalFields();

        return $this->renderAjax('tabs/additional_fields',[
            'fields' => $fields,
            'category' => $category,
            'model' => ($model_id != -1) ? $this->findModel($model_id) : null
        ]);
    }


    /**
     * elon egasi haqida info
     * @param $id
     * @return array|string
     * @throws NotFoundHttpException
     */
    public function actionUserInfo($id)
    {
        $item_id = $id;
        $user = $this->findModel($id)->user;
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "<p class='text-center'><b>Информация о пользователе</b></p>",
                    'size' => 'large',
                    'content'=>$this->renderAjax('user-info', [
                        'model' => $user,
                        'item_id' => $item_id,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-sm btn-inverse pull-left','data-dismiss'=>"modal"]).
                            Html::a('Редактировать #' . $user->id,['/users/users/edit-info','id'=>$user->id],['class'=>'btn btn-sm btn-primary','data-pjax' => 0])
                ];    
        }else{
            return $this->render('user-info', [
                'model' => $user,
                'item_id' => $item_id,
            ]);
        }
    }


    /**
     * userni statusini ozgartirish
     * @param $id
     * @param $status
     * @return array
     * @throws \yii\db\Exception
     */
    public function actionChangeStatusUser($id,$status)
    {
        $request = Yii::$app->request;
        Yii::$app->db->createCommand()
             ->update('users', ['status' => $status], ['id' => $id])
             ->execute();
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $tab = isset($_COOKIE["tab-items"]) && $_COOKIE["tab-items"] != 'undefined' ? $_COOKIE["tab-items"] : 'tab-1';
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-items-'.$tab];
        }
    }


    /**
     * elon qoshish
     * @return string|Response
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Items();  
        $model->tab = 'tab-1';

        if ($model->load($request->post()) && $model->save()) {
            $model->setLink();
            $model->newSaveImg($_POST);
            Yii::$app->session->setFlash('success', 'Успешно создан.');
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'category' => $model->cat,
                'upload_images' =>[],
                'post' => $_POST,
                'fields' => [],
            ]);
        }
    }


    /**
     * elonni ozgartirish
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $user_id = Yii::$app->user->identity->id;
        $searchModelAll = new ItemsClaimSearch();
        $dataProviderAll = $searchModelAll->search(Yii::$app->request->queryParams,$model->id);
        $model->price = number_format($model->price, 0, '.', ' ');

        $searchModelActive = new ItemsClaimSearch();
        $dataProviderActive = $searchModelActive->searchActive(Yii::$app->request->queryParams,$model->id);

        $upload_images = $model->getImages();
        $chats_count = ChatUsers::find()
            ->andWhere(['item_id'=>$model->id])
            ->andWhere(['!=','user_id' ,$model->user_id])
            ->count();
        $category = $model->cat;
        $langs = Lang::getLanguages();
        $category->getPriceSett($langs);
        $fields = $category->getAdditionalFields();
        $itemLink = Yii::$app->params['itemLink'] . $model->link;

        if ($model->load($request->post()) && $model->save()) {
            $model->newSaveImg($_POST);
            $model->setAfterChangeImage();
            Yii::$app->session->setFlash('success', 'Изменения сохранены.');
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'post' => $_POST,
                'fields' => $fields,
                'category' => $category,
                'model' => $model,
                'itemLink' => $itemLink,
                'upload_images' => $upload_images,
                'searchModelAll' => $searchModelAll,
                'dataProviderAll' => $dataProviderAll,
                'searchModelActive' => $searchModelActive,
                'dataProviderActive' => $dataProviderActive,
                'chats_count' => $chats_count,
            ]);
        }
    }


    /**
     * elonni ochirish
     * @param $id
     * @param null $tab
     * @return array|Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id,$tab = null)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if($model) {
            $model->delete();
        }
        // $model->changeStatusTo(Items::STATUS_DELETED);

        if($request->isAjax){
            /*
            *   Процесс для ajax-запроса
            */
            $pjaxId = isset($tab) ? "$tab-pjax" : "tab-1";

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-items-'.$pjaxId];
        }else{
            /*
            *   Процесс для не-AJAX-запроса
            */
            return $this->redirect(['index']);
        }
    }


    /**
     * multi change status . bir nechta elonni statusini ozgartitish
     * @param $status
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionBulkChangeStatus($status)
    {        
        $request = Yii::$app->request;
        $user_id = Yii::$app->user->identity->id;
        $pks = explode(',', $request->post( 'pks' ));
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->changeStatusTo($status);
            if($status == 0){
                $model->setRassilkaActivateItems();
                ItemsScale::setBallItems($model);
                Yii::$app->db->createCommand()->update(
                    'items', ['moderated_id' => $user_id,'moderation_date' =>date('Y-m-d H:i:s')], [ 'id' => $model->id ])
                    ->execute();
            }
        }
        if($request->isAjax){
            /*
            *   Процесс для ajax-запроса
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            $tab = isset($_COOKIE["tab-items"]) && $_COOKIE["tab-items"] != 'undefined' ? $_COOKIE["tab-items"] : 'tab-1';
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-items-'.$tab];
        }else{
            /*
            *   Процесс для не-AJAX-запроса
            */
            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = Items::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }


    /**
     * trashga rasmlarni yuklash
     * @return false|string
     */
    public static function  actionSaveImgStorage()
    {
        $dir = '/web/uploads/trash/';
        $image_upload_val = [];
        for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
            $ext = "";
            $ext = substr(strrchr($_FILES['file']['name'][$i], "."), 1);
            if($ext != ""){
                $fPath = $_POST['names'][$i];
                $image_upload_val ['image['.$i.']'] =  new \CurlFile($_FILES['file']['tmp_name'][$i], $_FILES['file']['type'][$i], $fPath);

            }
        }
        // curl connection
        $ch = curl_init();
        // set curl url connection
        $curl_url = Yii::$app->params['image_site'].'/api/upload-file';
        // pass curl url
        curl_setopt($ch, CURLOPT_URL,$curl_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        // image upload Post Fields
        curl_setopt($ch, CURLOPT_POSTFIELDS,$image_upload_val);
        // set CURL ETURN TRANSFER type
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_result = curl_exec($ch);
        curl_close($ch);
        if($server_result) return Yii::$app->params['image_site'] . $dir ; else return false;
        exit;
    }


    public static function  actionRotateImage($id)
    {
        $dir = '/web/uploads/items/';
        $image = ItemsImages::find()->andWhere(['id' => $id])->one();
        if(!$image) return null;
        $add_name = $image->extstor_img_m[0];
        $imageName = $image->extstor_img_s;
        $imageName .=",". $image->extstor_img_m;
        $imageName .=",". $image->extstor_img_v;
        $imageName .=",". $image->extstor_img_z;
        $imageName .=",". $image->extstor_img_o;
        $result = [
            'image_name' => $imageName,
            'add_name' => $add_name,
        ];

        $image->extstor_img_s = $add_name.$image->extstor_img_s;
        $image->extstor_img_m = $add_name.$image->extstor_img_m;
        $image->extstor_img_v = $add_name.$image->extstor_img_v;
        $image->extstor_img_z = $add_name.$image->extstor_img_z;
        $image->extstor_img_o = $add_name.$image->extstor_img_o;
        $image->save(false);


        // curl connection
        $ch = curl_init();
        // set curl url connection
        $curl_url = Yii::$app->params['image_site'].'/api/image-rotate';
        // pass curl url
        curl_setopt($ch, CURLOPT_URL,$curl_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        // image upload Post Fields
        curl_setopt($ch, CURLOPT_POSTFIELDS,$result);
        // set CURL ETURN TRANSFER type
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_result = curl_exec($ch);
        curl_close($ch);
        if($server_result) return Yii::$app->params['image_site'] . $dir.$image->extstor_img_m ; else return false;
        exit;
    }


    /**
     *  yuklangan rasmni xotiradan o'chirish uchun
     * @param $value
     * @param null $id
     */
    public function actionDeleteImage($value,$id=null)
    {
        if($id != null){
            ItemsImages::deleteAll(['id' => $id]);
            Items::deleteImage($value,false);
        }else{
            Items::deleteImage($value,true);
        }
    }


    public function actionBulkChangeDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' ));
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            if($model){
                $model->delete();
            }
        }
        if($request->isAjax){
            /*
            *   Процесс для ajax-запроса
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            $tab = isset($_COOKIE["tab-items"]) && $_COOKIE["tab-items"] != 'undefined' ? $_COOKIE["tab-items"] : 'tab-1';
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-items-'.$tab];
        }else{
            /*
            *   Процесс для не-AJAX-запроса
            */
            return $this->redirect(['index']);
        }
    }


    /**
     * @param $id
     * @return ItemsClaim|null
     * @throws NotFoundHttpException
     */
    protected function findModelClaim($id)
    {
        if (($model = ItemsClaim::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }


    /**
     * ayni bir jalobani korish
     * @param $id
     * @return array|string
     * @throws NotFoundHttpException
     */
    public function actionViewClaim($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Жалобы №".$id,
                    'content'=>$this->renderAjax('tabs/view-claim', [
                        'model' => $this->findModelClaim($id),
                    ]),
                ];    
        }else{
            return $this->render('tabs/view-claim', [
                'model' => $this->findModelClaim($id),
            ]);
        }
    }


    /**
     * @param $id
     * @param null $tab
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionCheckClaim($id, $tab = null)
    {
        $request = Yii::$app->request;
        $model = $this->findModelClaim($id);
        $model->viewed = 1;
        $model->save(false);
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            $pjaxId = isset($tab) ? "$tab-pjax" : "pjax";

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-item-claims-'.$pjaxId];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }


    /**
     * Delete an existing ItemsClaim model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteClaim($id,$tab)
    {
        $request = Yii::$app->request;
        $this->findModelClaim($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            $pjaxId = isset($tab) ? "$tab-pjax" : "pjax";

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-item-claims-'.$pjaxId];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }


    /**
     * rasmlarni sortirovka qilish
     * @param $id
     * @return string|Response
     */
    public function actionSortingImage($id)
    {
        $request = Yii::$app->request;
        $model = Items::findOne($id);
        $upload_images = $model->getImages();

        if ($request->post()) {
            
            $explode = explode(';', $request->post()['idList']);
            foreach ($explode as $key => $imageId) {
                $image = ItemsImages::findOne($imageId);
                $image->num = ($key + 1);
                $image->save(false);
            }
            $model->setAfterChangeImage();
            return $this->redirect(['update', 'id' => $model->id]);
        } 
        else 
        {
            return $this->render('sorting-image', [
                'model' => $model,
                'upload_images' => $upload_images,
            ]);
        }
    }

    public function actionChangeVerified()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $model = Items::findOne($id);
        if($model->verified == 0) {$model->verified = 1;}
        else {$model->verified = 0;}
        $model->save(false);
    }

}
