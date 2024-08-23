<?php
namespace backend\controllers\settings;

use Yii;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use backend\models\references\Lang;
use backend\models\settings\SiteSettings;
use backend\models\settings\Settings;
use \yii\web\Response;
use yii\web\HttpException;  
use backend\models\users\RoleMethods;
use backend\components\StaticFunction;


class SiteSettingsController extends SettingsController
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
     * shu kontroller uchun ruxsatlarni yechish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $site = RoleMethods::getAccess($roles , 'site', 'site');
        $settings = RoleMethods::getAccess($roles , 'site', 'settings');
       
        if($site && $settings)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($settings)
        {   
            if($action->id =='index' || $action->id =='download-settings-file' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }


        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * site settings listi
     * @return string|Response
     * @throws \Throwable
     */
    public function actionIndex()
    {
        $langs = Lang::getLanguages();
        $post = Yii::$app->request->post();
        $model = new SiteSettings();
        $model->getTranslations($langs);

        if($model->load($post) && $model->validate()){
            $model->UploadImage();
            $model->saveModel($post);
            $model->SaveTranslates($post,$langs);
            Yii::$app->session->setFlash('success', 'Изменения сохранены.');
            return $this->redirect(['index']);
        }else{
            return $this->render('index',[
                'model' => $model,
                'langs' => $langs
            ]);
        }
    }


    /**
     * @return array|Response
     */
    public function actionDownloadSettingsFile()
    {   
        $request = Yii::$app->request;
        $my_file =  'uploads/php_file/'.'settings.php';
        $settins = Settings::find()->asArray()->all();
        $result = "";
        foreach ($settins as $key => $value) {
            $result .= "     '".$value['key']."'".'=>'."'".$value['value']."',\n";
        }
            
        $handle = fopen($my_file, 'w+') or die('Fayl hosil qila olmadi.');
        fwrite($handle, "<?php");
        fwrite($handle, "\n return [\n");
        fwrite($handle, $result);
        fwrite($handle, "\n];\n");
        fwrite($handle, "?>\n");
        fclose($handle);
        $homepage = StaticFunction::file_get_contents_curl(Yii::$app->params['settingsUrl']);
        $homepage = json_decode($homepage);

        if($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> "Уведомления",
                'content'=>$this->renderAjax('success', [
                    'homepage' => $homepage,
            ])];         
        } 
        else {
            return $this->redirect(['/settings/site-settings/button-site']);
        }
    }

    // *************************  site dagi cronlar uchun tugmalar *************************************
    public function actionButtonSite()
    {
        return $this->render('button');
    }

}
