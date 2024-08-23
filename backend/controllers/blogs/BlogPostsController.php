<?php

namespace backend\controllers\blogs;

use Yii;
use backend\models\blogs\BlogPosts;
use backend\models\blogs\BlogPostsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\HttpException;
use backend\models\references\Lang;
use yii\web\UploadedFile;
use backend\models\references\Translates;
use backend\models\blogs\BlogsPostsLikes;
use backend\models\blogs\BlogPostTags;
use backend\models\users\RoleMethods;

/**
 * BlogPostsController implements the CRUD actions for BlogPosts model.
 */
class BlogPostsController extends Controller
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
                    'delete-post-tag' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }


    /**
     *
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $blog = RoleMethods::getAccess($roles , 'blog', 'blog');
        $posts = RoleMethods::getAccess($roles , 'blog', 'posts');
        $tags = RoleMethods::getAccess($roles , 'blog', 'tags');
        
        if($blog && $posts)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($posts)
        {   
            if($action->id =='create' || $action->id =='update' || $action->id =='delete')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($tags)
        {   
            if($action->id =='update-post-tag' || $action->id =='add-tag' || $action->id =='delete-post-tag')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);

    }


    /**
     * blog postni listini olish
     * @return string
     */
    public function actionIndex()
    {    
        $searchModel = new BlogPostsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single BlogPosts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;

        $likesSearchModel = new BlogsPostsLikes();
        $likeDataProvider = $likesSearchModel->search(Yii::$app->request->queryParams, $id);
        $tagsSearchModel = new BlogPostTags();
        $tagsDataProvider = $tagsSearchModel->search(Yii::$app->request->queryParams, $id);        

        return $this->render('view', [
            'model' => $this->findModel($id),
            'likeDataProvider' => $likeDataProvider,
            'tagsDataProvider' => $tagsDataProvider,
        ]);
    }


    /**
     * Creates a new BlogPosts model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new BlogPosts();
        $langs = Lang::getLanguages();
        $post = $request->post();
        $translation_name = null;
        $translation_short_text = null;
        $translation_text = null;

        if ($model->load($request->post())  && $model->save()) {
            $model->setPostTags();
            $model->images = UploadedFile::getInstance($model, 'images');
            $model->upload();
            $attr = BlogPosts::NeedTranslation();
            foreach ($langs as $lang) {
                $l = $lang->url;
                if($l == 'ru') continue;
                foreach ($attr as $key => $value) {
                    $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                    if($t->count() == 1) {
                        $tt = $t->one();
                        $tt->field_value = $post["BlogPosts"][$value][$l];
                        $tt->save();
                    }
                    else{
                        $tt = new Translates();
                        $tt->table_name = $model->tableName();
                        $tt->field_id = $model->id;
                        $tt->field_name = $key;
                        $tt->field_value = $post["BlogPosts"][$value][$l];
                        $tt->language_code = $l;
                        $tt->save();
                    }
                }
            }

            return $this->redirect(['index']);
        } 
        else {
            return $this->render('create', [
                'model' => $model,
                'translation_name' => $translation_name,
                'translation_short_text' => $translation_short_text,
                'translation_text' => $translation_text,
                'langs' => $langs,
            ]);
        }
    }

    /**
     * Updates an existing BlogPosts model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $langs = Lang::getLanguages();
        $post = $request->post();
        $translation_name = null;
        $translation_short_text = null;
        $translation_text = null;
        $model->tags = $model->getTags();
        
        $translations = Translates::find()->where(['table_name' => $model->tableName(), 'field_id' => $model->id])->all();
        foreach ($translations as $key => $value) {
            if($value->field_name == 'title') $translation_name[$value->language_code] = $value->field_value;
            if($value->field_name == 'short_text') $translation_short_text[$value->language_code] = $value->field_value;
            if($value->field_name == 'text') {
                $translation_text[$value->language_code] = $value->field_value;
                $model->translation_text[$value->language_code] = $value->field_value;
            }
        }

        if($model->load($request->post()) && $model->save()) {
            $model->setPostTags();
            $model->images = UploadedFile::getInstance($model, 'images');
            $model->upload();


            $attr = BlogPosts::NeedTranslation();
            foreach ($langs as $lang) {
                $l = $lang->url;
                if($l == 'ru') continue;

                foreach ($attr as $key => $value) {
                    $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                    if($t->count() == 1) {
                        $tt = $t->one();
                        $tt->field_value = $post["BlogPosts"][$value][$l];
                        $tt->save();
                    }
                    else{
                        $tt = new Translates();
                        $tt->table_name = $model->tableName();
                        $tt->field_id = $model->id;
                        $tt->field_name = $key;
                        $tt->field_value = $post["BlogPosts"][$value][$l];
                        $tt->language_code = $l;
                        $tt->save();
                    }
                }
            }
            return $this->redirect(['index']);
        } 
        else {
            return $this->render('update', [
                'model' => $model,
                'translation_name' => $translation_name,
                'translation_short_text' => $translation_short_text,
                'translation_text' => $translation_text,
                'post' => $post,
                'langs' => $langs,
            ]);
        }
    }


    /**
     * Delete an existing BlogPosts model.
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
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }


     /**
     * Delete multiple existing BlogPosts model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
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
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }


    /**
     * Finds the BlogPosts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BlogPosts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlogPosts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }


    /**
     * statusini o'zgartish
     * @throws NotFoundHttpException
     */
    public function actionChangeEnabled()
    {
        $request = Yii::$app->request;
        $id = $request->post('id');

        $model = $this->findModel($id);
        if($model->status == 0){
            $model->status = 1;
        }else{
            $model->status = 0;
        }
        $model->save();     
    }


    /**
     * tag qoshish
     * @param $id
     * @return array
     */
    public function actionAddTag($id)
    {
        $request = Yii::$app->request;
        $model = new BlogPostTags();
        $model->blog_posts_id = $id;

        if($request->isAjax){

            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                
                return [
                    'forceReload' => '#tags-datatable-pjax',
                    'forceClose' => true,
                ];

            }else{
                 return [
                    'title'=> "Создать",
                    'content'=>$this->renderAjax('tabs/_tag_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }


    /**
     * postni update qilishni tagni ozgartish
     * @param $id
     * @return array
     */
    public function actionUpdatePostTag($id)
    {
        $request = Yii::$app->request;
        $model = BlogPostTags::findOne($id);

        if($request->isAjax){

            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                
                return [
                    'forceReload' => '#tags-datatable-pjax',
                    'forceClose' => true,
                ];

            }else{
                 return [
                    'title'=> "Изменить",
                    'content'=>$this->renderAjax('tabs/_tag_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }


    /**
     * Delete an existing BlogPosts model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeletePostTag($id)
    {
        $request = Yii::$app->request;
        BlogPostTags::findOne($id)->delete();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['forceClose'=>true,'forceReload'=>'#tags-datatable-pjax'];
    }
}
