<?php

namespace backend\controllers\items;

use Yii;
use backend\models\items\Categories;
use backend\models\items\CategoriesSearch;
use backend\models\items\CategoriesDynprops;
use backend\models\items\CategoriesDynpropsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\references\Lang;
use backend\models\users\RoleMethods;
use yii\web\HttpException;
use yii\filters\AccessControl;

/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class CategoriesController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * shu kontrollerga tegishli ruxsatlarni tekshirish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $bbs = RoleMethods::getAccess($roles , 'bbs', 'bbs');
        $categories = RoleMethods::getAccess($roles , 'bbs', 'categories');
        
        if($bbs && $categories)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($categories)
        {   
            if($action->id =='create' || $action->id =='update' || $action->id =='delete')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }
       
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);

    }


    /**
     * categoriyani litini olish
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * categoriyani o'zgartirish
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $langs = Lang::getLanguages();
        $model->getPriceSett($langs);
        $post = $request->post();
        $parentCategory = null;

        if($model->parent_id){
            $parentCategory = $model->parent;
        }
        $model->getTranslations($langs);
        if($request->post()){
            if($post['submit-button'] == Categories::TYPE_BASE){
                if ($model->load($request->post()) && $model->validate()) {
                    $model->savePriceSett($post);  
                    $model->save(); 
                    if($model->parent_id == 1)
                        $model->UploadImage();
                    $model->SaveTranslates($post,$langs);
                    return $this->redirect(['index']);
                }
            }
            if($post['submit-button'] == Categories::TYPE_SEO){
                if ($model->load($request->post()) && $model->save()) {
                    $model->SaveTranslates($post,$langs);
                    return $this->redirect(['index']);
                }
            }
            if($post['submit-button'] == Categories::TYPE_TEMPLATE){
                    $model->SaveTranslates($post,$langs);
                if ($model->load($request->post()) && $model->save()) {
                    return $this->redirect(['index']);
                }
            }
        }
        else {
            return $this->render('update', [
                'model' => $model,
                'langs' => $langs,
            ]);
        }
    }


    /**
     * @param $id
     * @return string
     */
    public function actionChangeActiveCat($id)
    {
        $categories = Yii::$app->session['categories'];
        if(isset($categories) && $categories != ""){
            $arr = explode(",", $categories);
            if(in_array($id, $arr)){
               foreach ($arr as $key => $value) {
                    if($value == $id){
                        unset($arr[$key]);
                    }
                } 
                $result = "deleted";
            }else{
                $arr[] = $id;
                $result = "added";
            }
        }else{
            $arr = [];
            $arr[] = $id; 
                $result = "added";
        }
        
        $categories = implode(",", $arr);
        $session = Yii::$app->session;
        $session['categories'] =  $categories;
        return $result;
    }


    /**
     * Creates a new Categories model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
    */
    public function actionCreate($id = null)
    {
        $request = Yii::$app->request;
        $model = new Categories();  
        $parentCategory = null;
        if($id){
           $model->parent_id = $id;
           $parentCategory = $model->parent;
        }
        $model->price = 1;
        $model->owner_business = 1;
        $model->ex = 0;
        $post = $request->post();
        $langs = Lang::getLanguages();
        if($request->post()){
            if($post['submit-button'] == Categories::TYPE_BASE){
                if ($model->load($request->post()) && $model->validate()) {
                    $model->savePriceSett($post);  
                    $model->save(); 
                    if($model->parent_id == 1)
                        $model->UploadImage();
                    $model->SaveTranslates($post,$langs);
                    $model->setKeywordEvalution();
                    return $this->redirect(['index']);
                }
            }
            if($post['submit-button'] == Categories::TYPE_SEO){
                if ($model->load($request->post()) && $model->save()) {
                    $model->SaveTranslates($post,$langs);
                    $model->setKeywordEvalution();
                    return $this->redirect(['index']);
                }
            }
            if($post['submit-button'] == Categories::TYPE_TEMPLATE){
                if ($model->load($request->post()) && $model->save()) {
                    $model->SaveTranslates($post,$langs);
                    $model->setKeywordEvalution();
                    return $this->redirect(['index']);
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'langs' => $langs,
            ]);
        }
    }


    /**
     * Deletes an existing Categories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();
        if($request->isAjax){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            return $this->redirect(['index']);
        }
    }


    /**
     * sortirovka , categoriyani sortirovka qilish
     * @param null $id
     * @return string|\yii\web\Response
     */
    public function actionSorting($id = null)
    {
        $request = Yii::$app->request;
        $list = Categories::getColumnsList($id);
        if($request->post()){
            $i = 0;
            $result = [];
            $string = $request->post()['sort'];
            if($string != null && !is_array($string)){
                $result = explode(',', $string);
            }
            foreach ($result as $value) {
                if(!$value) continue;
                $i++;
                $subCategories = Categories::findOne($value);
                $subCategories->sorting = $i;
                $subCategories->save(false);
            }
            return $this->redirect(['index']);
        }else{           
            return $this->render('_sorting_form', [
                'list' => $list,
            ]);
        }       
    }


    /**
     * settings , qoshimcha polyalar listin olish
     * @param $id
     * @param $name
     * @return string
     */
    public function actionSettings($id,$name)
    {
        $searchModel = new CategoriesDynpropsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        return $this->render('settings/index', [
            'category_id' => $id,
            'category_name' => $name,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * categoriyaga qoshimcha polya qoshish
     * @param $id
     * @param $name
     * @return string|\yii\web\Response
     */
    public function actionCreateSettings($id,$name)
    {
        $request = Yii::$app->request;
        $model = new CategoriesDynprops();  
        $model->category_id = $id;
        $post = $request->post();
        $langs = Lang::getLanguages();
        $variants = $model->getVariants();
        if ($model->load($request->post()) && $model->validate()) {
            $model->save();
            $model->SaveTranslates($post,$langs);
            $model->saveVariants($post,$langs);
            return $this->redirect(['settings','id' => $model->category_id, 'name' => $name]);
        } else {
            return $this->render('settings/create', [
                'model' => $model,
                'name' => $name,
                'langs' => $langs,
                'variants' => $variants,
            ]);
        }
    }


    /**
     * qoshilgan qoshimcha polyalarni ozgartirish
     * @param $id
     * @param $name
     * @return string|\yii\web\Response
     */
    public function actionUpdateSettings($id,$name)
    {
        $request = Yii::$app->request;
        $model = CategoriesDynprops::findOne($id);  
        $post = $request->post();
        $langs = Lang::getLanguages();
        $variants = $model->getVariants();
        $model->getTranslations($langs);
        if ($model->load($request->post()) && $model->validate()) {
            $model->save();
            $model->SaveTranslates($post,$langs);
            $model->saveVariants($post,$langs);
            return $this->redirect(['settings','id' => $model->category_id, 'name' => $name]);
        } else {
            return $this->render('settings/update', [
                'model' => $model,
                'name' => $name,
                'langs' => $langs,
                'variants' => $variants,
            ]);
        }
    }


    /**
     * @param $id
     */
    public function actionChangeSearch($id)
    {
        $model = CategoriesDynprops::findOne($id);
        $i = $model->in_search;
        $i = ($i + 1)% 2;
        $model->in_search = $i;
        $model->save(false);    
    }


    /**
     * qoshimcha polyani ozgartirish
     * @param $id
     * @return array|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteSetting($id)
    {
        $request = Yii::$app->request;
        $model = CategoriesDynprops::findOne($id);
        if($model)
            $model->delete();
        if($request->isAjax){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            return $this->redirect(['index']);
        }
    }


    /**
     * for dyn drop is published for telegram access
     * @return int|mixed|null
     * @throws NotFoundHttpException
     */
    public function actionActiveChange(){
        $id = Yii::$app->request->post('id');
        $model = CategoriesDynprops::findOne($id);
        if($model->published_telegram == 1) {
            $model->published_telegram = 0;
        }
        else {
            $model->published_telegram = 1;
        }
        $model->save(false);
        return $model->published_telegram;
    }



    /**
     * Finds the Categories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categories::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
