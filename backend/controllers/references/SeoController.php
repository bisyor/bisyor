<?php

namespace backend\controllers\references;

use Yii;
use backend\models\references\Seo;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\references\Lang;
use backend\models\references\Translates;
use backend\models\users\RoleMethods;
use yii\web\HttpException;
use backend\components\StaticFunction;

/**
 * SeoController implements the CRUD actions for Seo model.
 */
class SeoController extends Controller
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
     * shu controllerga tegishli  ruxsatlarni tekshirish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $blogs = RoleMethods::getAccess($roles , 'blog', 'seo');
        $help = RoleMethods::getAccess($roles , 'help', 'seo');
        $users_seo = RoleMethods::getAccess($roles , 'users', 'seo');
        $shops_seo = RoleMethods::getAccess($roles , 'shops', 'seo');
        $items = RoleMethods::getAccess($roles , 'bbs', 'seo');
        $settings = RoleMethods::getAccess($roles , 'seo', 'settings');

        if($blogs)
        {   
            if($action->id =='blogs')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($help)
        {   
            if($action->id =='helps')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($users_seo)
        {   
            if($action->id =='users')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($shops_seo)
        {   
            if($action->id =='shops')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($items)
        {   
            if($action->id =='items')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($settings)
        {
            if($action->id =='robots')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);

    }


    /**
     * elonlar seoi
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionItems()
    {
        $request = Yii::$app->request;
        $langs = Lang::getLanguages();
        $model = new Seo();
        $seoList = Seo::find()->where(['group' => 'items'])->all();
        $titles = [];

        $trList = [];
        $translations = Translates::find()->where(['table_name' => $model->tableName()])->all();
        foreach ($translations as $value) {
            $key = $value->field_name . '_' . $value->language_code;
            $trList[$key] = $value->field_value;


        }
        if ($request->post()) {
            $result = $request->post()['Seo']['translation_name'];

            foreach ($seoList as $seo) {
                foreach ($langs as $lang) {
                    $key = $seo->key . '_' . $lang->url;
                    if($lang->default) {
                       $seo->value = isset($result[$key]) ? $result[$key] : '';
                        $seo->save();
                    }
                    else {
                        if(isset($trList[$key])) {
                            Yii::$app->db->createCommand()->update('translates', 
                                ['field_value' => isset($result[$key]) ? $result[$key] : ''], 
                                ['table_name' => $model->tableName(), 'field_name' => $seo->key, 'language_code' => $lang->url ])
                            ->execute();
                        }
                        else {
                            $tr = new Translates();
                            $tr->table_name = $model->tableName();
                            $tr->field_id = $seo->id;
                            $tr->field_name = $seo->key;
                            $tr->field_value = isset($result[$key]) ? $result[$key] : '';
                            $tr->language_code = $lang->url;
                            $tr->save();
                        }
                    }
                }
            }

            return $this->redirect(['items']);
        } 
        else {
            foreach ($seoList as $seo) {
                foreach ($langs as $lang) {
                    $key = $seo->key . '_' . $lang->url;
                    if($lang->default) {
                        $titles[$key] = $seo->value;
                    }
                    else {
                        if(isset($trList[$key])) $titles[$key] = $trList[$key];
                        else $titles[$key] = '';
                    }
                }
            }

            return $this->render('items', [
                'langs' => $langs,
                'model' => $model,
                'titles' => $titles,
            ]);
        }
    }


    /**
     * magazinlar seosi
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionShops()
    {
        $request = Yii::$app->request;
        $langs = Lang::getLanguages();
        $model = new Seo();
        $seoList = Seo::find()->where(['group' => 'shops'])->all();
        $titles = [];

        $trList = [];
        $translations = Translates::find()->where(['table_name' => $model->tableName()])->all();
        foreach ($translations as $value) {
            $key = $value->field_name . '_' . $value->language_code;
            $trList[$key] = $value->field_value;
        }

        if ($request->post()) {
            $result = $request->post()['Seo']['translation_name'];

            foreach ($seoList as $seo) {
                foreach ($langs as $lang) {
                    $key = $seo->key . '_' . $lang->url;
                    if($lang->default) {
                        $seo->value = $result[$key];
                        $seo->save();
                    }
                    else {
                        if(isset($trList[$key])) {
                            Yii::$app->db->createCommand()->update('translates', 
                                ['field_value' => $result[$key]], 
                                ['table_name' => $model->tableName(), 'field_name' => $seo->key, 'language_code' => $lang->url ])
                            ->execute();
                        }
                        else {
                            $tr = new Translates();
                            $tr->table_name = $model->tableName();
                            $tr->field_id = $seo->id;
                            $tr->field_name = $seo->key;
                            $tr->field_value = $result[$key];
                            $tr->language_code = $lang->url;
                            $tr->save();
                        }
                    }
                }
            }

            return $this->redirect(['shops']);
        } 
        else {
            foreach ($seoList as $seo) {
                foreach ($langs as $lang) {
                    $key = $seo->key . '_' . $lang->url;
                    if($lang->default) {
                        $titles[$key] = $seo->value;
                    }
                    else {
                        if(isset($trList[$key])) $titles[$key] = $trList[$key];
                        else $titles[$key] = '';
                    }
                }
            }

            return $this->render('shops', [
                'langs' => $langs,
                'model' => $model,
                'titles' => $titles,
            ]);
        }
    }


    /**
     * users
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionUsers()
    {
        $request = Yii::$app->request;
        $langs = Lang::getLanguages();
        $model = new Seo();
        $seoList = Seo::find()->where(['group' => 'users'])->all();
        $titles = [];

        $trList = [];
        $translations = Translates::find()->where(['table_name' => $model->tableName()])->all();
        foreach ($translations as $value) {
            $key = $value->field_name . '_' . $value->language_code;
            $trList[$key] = $value->field_value;
        }

        if ($request->post()) {
            $result = $request->post()['Seo']['translation_name'];

            foreach ($seoList as $seo) {
                foreach ($langs as $lang) {
                    $key = $seo->key . '_' . $lang->url;
                    if($lang->default) {
                        $seo->value = $result[$key];
                        $seo->save();
                    }
                    else {
                        if(isset($trList[$key])) {
                            Yii::$app->db->createCommand()->update('translates', 
                                ['field_value' => $result[$key]], 
                                ['table_name' => $model->tableName(), 'field_name' => $seo->key, 'language_code' => $lang->url ])
                            ->execute();
                        }
                        else {
                            $tr = new Translates();
                            $tr->table_name = $model->tableName();
                            $tr->field_id = $seo->id;
                            $tr->field_name = $seo->key;
                            $tr->field_value = $result[$key];
                            $tr->language_code = $lang->url;
                            $tr->save();
                        }
                    }
                }
            }

            return $this->redirect(['users']);
        } 
        else {
            foreach ($seoList as $seo) {
                foreach ($langs as $lang) {
                    $key = $seo->key . '_' . $lang->url;
                    if($lang->default) {
                        $titles[$key] = $seo->value;
                    }
                    else {
                        if(isset($trList[$key])) $titles[$key] = $trList[$key];
                        else $titles[$key] = '';
                    }
                }
            }

            return $this->render('users', [
                'langs' => $langs,
                'model' => $model,
                'titles' => $titles,
            ]);
        }
    }


    /**
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionBlogs()
    {
        $request = Yii::$app->request;
        $langs = Lang::getLanguages();
        $model = new Seo();
        $seoList = Seo::find()->where(['group' => 'blogs'])->all();
        $titles = [];

        $trList = [];
        $translations = Translates::find()->where(['table_name' => $model->tableName()])->all();
        foreach ($translations as $value) {
            $key = $value->field_name . '_' . $value->language_code;
            $trList[$key] = $value->field_value;
        }

        if ($request->post()) {
            $result = $request->post()['Seo']['translation_name'];

            foreach ($seoList as $seo) {
                foreach ($langs as $lang) {
                    $key = $seo->key . '_' . $lang->url;
                    if($lang->default) {
                        $seo->value = $result[$key];
                        $seo->save();
                    }
                    else {
                        if(isset($trList[$key])) {
                            Yii::$app->db->createCommand()->update('translates', 
                                ['field_value' => $result[$key]], 
                                ['table_name' => $model->tableName(), 'field_name' => $seo->key, 'language_code' => $lang->url ])
                            ->execute();
                        }
                        else {
                            $tr = new Translates();
                            $tr->table_name = $model->tableName();
                            $tr->field_id = $seo->id;
                            $tr->field_name = $seo->key;
                            $tr->field_value = $result[$key];
                            $tr->language_code = $lang->url;
                            $tr->save();
                        }
                    }
                }
            }

            return $this->redirect(['blogs']);
        } 
        else {
            foreach ($seoList as $seo) {
                foreach ($langs as $lang) {
                    $key = $seo->key . '_' . $lang->url;
                    if($lang->default) {
                        $titles[$key] = $seo->value;
                    }
                    else {
                        if(isset($trList[$key])) $titles[$key] = $trList[$key];
                        else $titles[$key] = '';
                    }
                }
            }
           /* echo "<pre>";
            print_r($titles);
            echo "</pre>";
            die;*/

            return $this->render('blogs', [
                'langs' => $langs,
                'model' => $model,
                'titles' => $titles,
            ]);
        }
    }


    /**
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionHelps()
    {
        $request = Yii::$app->request;
        $langs = Lang::getLanguages();
        $model = new Seo();
        $seoList = Seo::find()->where(['group' => 'helps'])->all();
        $titles = [];

        $trList = [];
        $translations = Translates::find()->where(['table_name' => $model->tableName()])->all();
        foreach ($translations as $value) {
            $key = $value->field_name . '_' . $value->language_code;
            $trList[$key] = $value->field_value;
        }

        if ($request->post()) {
            $result = $request->post()['Seo']['translation_name'];

            foreach ($seoList as $seo) {
                foreach ($langs as $lang) {
                    $key = $seo->key . '_' . $lang->url;
                    if($lang->default) {
                        $seo->value = $result[$key];
                        $seo->save();
                    }
                    else {
                        if(isset($trList[$key])) {
                            Yii::$app->db->createCommand()->update('translates', 
                                ['field_value' => $result[$key]], 
                                ['table_name' => $model->tableName(), 'field_name' => $seo->key, 'language_code' => $lang->url ])
                            ->execute();
                        }
                        else {
                            $tr = new Translates();
                            $tr->table_name = $model->tableName();
                            $tr->field_id = $seo->id;
                            $tr->field_name = $seo->key;
                            $tr->field_value = $result[$key];
                            $tr->language_code = $lang->url;
                            $tr->save();
                        }
                    }
                }
            }

            return $this->redirect(['helps']);
        } 
        else {
            foreach ($seoList as $seo) {
                foreach ($langs as $lang) {
                    $key = $seo->key . '_' . $lang->url;
                    if($lang->default) {
                        $titles[$key] = $seo->value;
                    }
                    else {
                        if(isset($trList[$key])) $titles[$key] = $trList[$key];
                        else $titles[$key] = '';
                    }
                }
            }

            return $this->render('helps', [
                'langs' => $langs,
                'model' => $model,
                'titles' => $titles,
            ]);
        }
    }


    /**
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionSettings()
    {
        $request = Yii::$app->request;
        $langs = Lang::getLanguages();
        $model = new Seo();
        $seoList = Seo::find()->where(['group' => 'site-settings'])->all();
        $titles = [];

        $trList = [];
        $translations = Translates::find()->where(['table_name' => $model->tableName()])->all();
        foreach ($translations as $value) {
            $key = $value->field_name . '_' . $value->language_code;
            $trList[$key] = $value->field_value;
        }

        if ($request->post()) {
            $result = $request->post()['Seo']['translation_name'];

            foreach ($seoList as $seo) {
                foreach ($langs as $lang) {
                    $key = $seo->key . '_' . $lang->url;
                    if($lang->default) {
                        $seo->value = $result[$key];
                        $seo->save();
                    }
                    else {
                        if(isset($trList[$key])) {
                            Yii::$app->db->createCommand()->update('translates', 
                                ['field_value' => $result[$key]], 
                                ['table_name' => $model->tableName(), 'field_name' => $seo->key, 'language_code' => $lang->url ])
                            ->execute();
                        }
                        else {
                            $tr = new Translates();
                            $tr->table_name = $model->tableName();
                            $tr->field_id = $seo->id;
                            $tr->field_name = $seo->key;
                            $tr->field_value = $result[$key];
                            $tr->language_code = $lang->url;
                            $tr->save();
                        }
                    }
                }
            }

            return $this->redirect(['settings']);
        } 
        else {
            foreach ($seoList as $seo) {
                foreach ($langs as $lang) {
                    $key = $seo->key . '_' . $lang->url;
                    if($lang->default) {
                        $titles[$key] = $seo->value;
                    }
                    else {
                        if(isset($trList[$key])) $titles[$key] = $trList[$key];
                        else $titles[$key] = '';
                    }
                }
            }

            return $this->render('site-settings', [
                'langs' => $langs,
                'model' => $model,
                'titles' => $titles,
            ]);
        }
    }


    /**
     * @return string
     */
    public function actionRobots()
    {   
        $lastChange = date('02:00 d.m.Y');
        $xml = simplexml_load_file("uploads/sitemap/sitemap.xml");
        foreach($xml as $key => $children) {
            $lastChange = date('H:i d.m.Y', strtotime($children->lastmod));
            break;
        }

        $file =  'uploads/robots/'.'settings.txt';
        if(isset($_POST['text']) && $_POST['text'] != null)
        {
            $handle = fopen($file, 'w+') or die('Fayl hosil qila olmadi.');
            fwrite($handle, $_POST['text']);
        }
        $text = StaticFunction::file_get_contents_curl($file);
        $homepage = StaticFunction::file_get_contents_curl(Yii::$app->params['robotsUrl']);

        return $this->render('robots', [
            'text' => $text,
            'lastChange' => $lastChange,
        ]);
    }


    /**
     * @return \yii\web\Response
     */
    public function actionRunHandle()
    {
        $runHandle = StaticFunction::file_get_contents_curl(Yii::$app->params['runHandle']);
        return $this->redirect(['/references/seo/robots']);
    }
}
