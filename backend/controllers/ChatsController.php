<?php

namespace backend\controllers;

use backend\models\items\Items;
use backend\models\users\Users;
use Yii;
use backend\models\chats\Chats;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use backend\models\chats\ChatMessage;
use backend\models\chats\ChatUsers;
use backend\models\chats\Comments;
use yii\web\HttpException;
use backend\models\users\RoleMethods;

/**
 * ChatsController implements the CRUD actions for Chats model.
 */
class ChatsController extends Controller
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
     * shu controllerga tegishli ruxsatlarni tekshirish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $spy = RoleMethods::getAccess($roles , 'internalmail', 'spy');
        $my = RoleMethods::getAccess($roles , 'internalmail', 'my');
        $internalmail = RoleMethods::getAccess($roles , 'internalmail', 'edit');
        $items_comments = RoleMethods::getAccess($roles , 'bbs', 'items_comments');

        if($internalmail && $spy && $my)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($my)
        {   
            if($action->id =='set-tab')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($spy)
        {   
            if($action->id =='index' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($items_comments)
        {   
            if($action->id =='delete-message' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * @param null $chat_id
     * @param int $pagination
     * @param int $type
     * @param null $item_id
     * @return string
     */
    public function actionIndex($chat_id = null, $page = 0 , $type = 0 ,$item_id = null)
    {
        $check_all_items = true;
        if($type == 0) {
            $type = Yii::$app->session['type'] != null ? Yii::$app->session['type'] : '1';
        } else {
            $session = Yii::$app->session;
            $session['type'] = $type;
        }
        $user_id = Yii::$app->user->identity->id;
        if($type == 1) {
            $query = ChatUsers::find()
                ->leftJoin('chats', 'chats.id=chat_users.chat_id')
                ->leftJoin('chat_message', 'chat_message.chat_id = chat_users.chat_id')
                ->with(['user', 'lastMessage', 'lastCount', 'items', 'chat'])
                ->where(['!=', 'chat_users.user_id', 1])
                ->andWhere(['chats.type' => $type])
                ->orderBy(['chat_message.date_cr' => SORT_DESC]);
            $usersList = ChatUsers::getUsersList($query);
        }

        elseif($type == 3 || $type == 4){
            $query = Chats::find()
                ->leftJoin('chat_message', 'chat_message.chat_id = chats.id')
                ->with(['lastMessage', 'lastCount','items'])
                ->andWhere(['chats.type' => $type])
            ->orderBy(['chat_message.date_cr' => SORT_DESC]);

            $usersList = Chats::getUsersList($query);
        }

        elseif($type == 6 && $item_id != null){
            $item = Items::find()->where(['id'=> $item_id])->one();
            if($item) $user = $item->user_id; else $user = $user_id;
            $chatUsers = ChatUsers::find()->where(['user_id' => $user,'item_id' => $item_id])->select('chat_id')->asArray()->all();
            $chatUsers = array_column($chatUsers , 'chat_id');
            $query =  ChatUsers::find()
                ->leftJoin('chats','chats.id=chat_users.chat_id')
                ->leftJoin('items','items.id=chat_users.item_id')
                ->leftJoin('chat_message', 'chat_message.chat_id = chat_users.chat_id')
                ->with(['lastMessage','lastCount','items','chat','user'])
                ->andWhere(['!=', 'chat_users.user_id', $user])
                ->andWhere(['chat_users.chat_id' => $chatUsers])
                ->andWhere(['chats.type' => 6])
                ->orderBy(['chat_message.date_cr' => SORT_DESC]);
            $usersList = ChatUsers::getUsersList($query);
        } else {
            $check_all_items = false;
            $query =  ChatUsers::find()
                ->leftJoin('chats','chats.id=chat_users.chat_id')
                ->with(['lastMessage','lastCount','items','chat','user'])
                ->leftJoin('items','items.id=chat_users.item_id')
                ->andWhere(['chats.type' => 6])
                ->andWhere(['is not', 'chat_users.item_id' ,null])
                ->andWhere('"chat_users"."user_id" = "items"."user_id"')
                ->orderBy(['chat_users.date_cr' => SORT_DESC]);
            $usersList = ChatUsers::getUsersList($query);
        }

        $query_mesaage = ChatMessage::find()
            ->with(['user'])
            ->where(['chat_id' => $chat_id])
            ->orderBy(['date_cr' => SORT_ASC]);

        $messageList = ChatMessage::getMessageList($query_mesaage,$user_id);
        $roles = RoleMethods::getUsersRole();
        $items_comments = RoleMethods::getAccess($roles , 'bbs', 'items_comments');
        $items =  Chats::getNameItems($chat_id ,$type);
        $currentUser = null;
        if($type == 1 && $chat_id)
        {
            $chats = \backend\models\chats\ChatUsers::find()
                ->leftJoin('chats','chats.id=chat_users.chat_id')
                ->andWhere(['!=','chat_users.user_id',1])
                ->andWhere(['chats.type' => 1])
                ->andWhere(['chats.id' => $chat_id])
                ->one();
            $currentUser = Users::find()->andWhere(['id' => $chats->user_id])->select(['id','fio','phone','email'])->one();
        }
         return $this->render('index', [
             'chat_live' =>$messageList,
             'chat_id' => $chat_id,
             'usersList'=>$usersList,
             'type' => $type,
             'pagination' =>$page,
             'items' =>$items,
             'delete_but' => $items_comments,
             'user_id' =>$user_id,
             'item_id' => $item_id,
             'check_all_items' => $check_all_items,
             'currentUser' => $currentUser,
         ]);
    }


    /**
     * @param $uname
     * @param $msg
     * @return bool
     */
    public function actionSendMessage($uname, $msg)
    {
        $chat = Chats::find()->where(['id' =>$uname])->one();
        if(!$chat){
           return false;
        }
        $chatMessage = new ChatMessage();
        $chatMessage->chat_id = $uname;
        $chatMessage->message = $msg;
        $chatMessage->user_id = $chat->type == 1 ? 1 : (integer)Yii::$app->user->identity->id;
        if($chatMessage->validate()){
            $chatMessage->save();
            return true;
        }
        else {
           return false;
        }
    }


    /**
     * @return array|Response
     */
    public function actionSendMultiple()
    {
        $request = Yii::$app->request;
        $model = new Comments(); 
        $model->step = 1;
        if($request->isAjax){
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->validate()){
                $model->type = Yii::$app->session['type'];
                $model->sendMultipleMesage();
                return $this->redirect('index');
            }else{           
                return [
                    'title'=> "Создать",
                    'content'=>$this->renderAjax('_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Отправить',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }
    }


    /**
     * elonga tegishli chatlar listi
     * @param null $user_id
     * @param null $item_id
     * @return string
     */
    public function actionItemsChats($user_id = null ,$item_id = null){
        $type = 6;
        $session = Yii::$app->session;
        $session['type'] = $type;

        $identity = Yii::$app->user->identity;
        $chat_id = null;
        $chatUsers = ChatUsers::find()
            ->leftJoin('chats','chats.id=chat_users.chat_id')
            ->andwhere(['chat_users.item_id' => $item_id])
            ->andwhere(['chat_users.user_id' => $identity->id])
            ->andwhere(['chats.type' => 6])
            ->andwhere(['chats.field_id' => $item_id])
            ->one();
        if($chatUsers == null) {
            $chat = new Chats();
            $chat->name = 'items_chats_' . $item_id.'_'.$identity->id;
            $chat->field_id = $item_id;
            $chat->type = 6;
            $chat->save();
            $chat_id = $chat->id;

            $chat_user_1 = new ChatUsers();
            $chat_user_1->chat_id = $chat->id;
            $chat_user_1->user_id = $user_id;
            $chat_user_1->item_id = $item_id;
            $chat_user_1->save();

            $chat_user_2 = new ChatUsers();
            $chat_user_2->chat_id = $chat->id;
            $chat_user_2->user_id = $identity->id;
            $chat_user_2->item_id = $item_id;
            $chat_user_2->save();
        }
        else {
            $chat_id = $chatUsers->chat_id;
            $chat_user_1 =  (new \yii\db\Query())
                ->from('chat_users')
                ->where(['chat_id' => $chat_id, 'user_id' => $identity->id])
                ->one();
            if($chat_user_1 == null) {
                $chat_user_1 = new ChatUsers();
                $chat_user_1->chat_id = $chat_id;
                $chat_user_1->user_id = $identity->id;
                $chat_user_1->item_id = $item_id;
                $chat_user_1->save();
            }

            $chat_user_2 =  (new \yii\db\Query())
                ->from('chat_users')
                ->where(['chat_id' => $chat_id, 'user_id' => $user_id])
                ->one();
            if($chat_user_2 == null) {
                $chat_user_2 = new ChatUsers();
                $chat_user_2->chat_id =$chat_id;
                $chat_user_2->user_id = $identity->id;
                $chat_user_2->item_id = $item_id;
                $chat_user_2->save();
            }
        }

        $items =  Chats::getNameItems($chat_id ,$type);
        $query =  ChatUsers::find()
            ->leftJoin('chats','chats.id=chat_users.chat_id')
            ->with(['lastMessage','lastCount','items','chat','user'])
            ->andWhere(['!=', 'chat_users.user_id', $identity->id])
            ->andWhere(['chat_users.chat_id' => $chat_id])
            ->andWhere(['chats.type' => 6]);
        $usersList = ChatUsers::getUsersList($query);

        $query_mesaage = ChatMessage::find()
            ->joinWith(['chat', 'user'])
            ->where(['chats.id' => $chat_id])
            ->orderBy(['date_cr' => SORT_ASC]);
        $messageList = ChatMessage::getMessageList($query_mesaage,$identity->id);

        return $this->render('index', [
            'chat_live' =>$messageList,
            'chat_id' => $chat_id,
            'usersList'=>$usersList,
            'type' => 6,
            'pagination' => 0,
            'items' =>$items,
            'delete_but' => '',
            'user_id' =>$identity->id,
            'item_id' => $item_id,
            'check_all_items' => true,
        ]);
    }


    /**
     * @param $value
     * @return Response
     */
    public function actionSetTab($value)
    {
        $session = Yii::$app->session;
        $session['type'] = $value;
        return $this->redirect(['index']);
    }


    /**
     * delete message for message
     * @param $id
     * @throws \yii\db\Exception
     */
    public function actionDeleteMessage($id)
    {   
        $request = Yii::$app->request;
        \Yii::$app->db->createCommand()
            ->delete('chat_message', ['id' => $id])
            ->execute();
    }


    /**
     * update message
     * @param $id
     * @return array
     */
    public function actionUpdateMsg($id)
    {
        $request = Yii::$app->request;
        $model = ChatMessage::findOne($id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            if($model->load($request->post()) && $model->save(false)) {
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Изменить",
                    'forceClose'=>true,
                ];         
            } 
            else {
                 return [
                    'title'=> "Изменить",
                    'content'=>$this->renderAjax('_form_msg', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }
    }


    /**
     * @param $id
     * @return array
     */
    public function actionUpdateOdob($id)
    {
        $request = Yii::$app->request;
        $model = ChatMessage::findOne($id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            if($model->load($request->post()) && $model->save(false)) {
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Одобрить",
                    'forceClose'=>true,
                ];         
            } 
            else {
                 return [
                    'title'=> "Одобрить",
                    'content'=>$this->renderAjax('_form_odob', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }
    }
}
