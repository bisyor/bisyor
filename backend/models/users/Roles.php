<?php

namespace backend\models\users;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $color Цветь
 * @property string|null $key Ключ
 * @property bool|null $admin_access Доступ к админ панелю
 *
 * @property UserRoles[] $userRoles
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admin_access'], 'boolean'],
            [['name', 'color', 'key'], 'string', 'max' => 255],
            [['name', 'key', 'color', 'admin_access'], 'required'],
            [['name', 'key'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'color' => 'Цвет',
            'key' => 'Ключ',
            'admin_access' => 'Доступ к админ панелю',
        ];
    }

    /**
     * Gets query for [[UserRoles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles()
    {
        return $this->hasMany(UserRoles::className(), ['role_id' => 'id']);
    }
    public function afterSave($insert, $changedAttributes)
    {
        if($insert){
            $module = ModuleMethods::find()->asArray()->all();
            foreach ($module as $value){
                $model = new RoleMethods();
                $model->role_id = $this->id;
                $model->method_id = $value['id'];
                $model->value = 0;
                $model->save();
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public static function itemsMethods($methods, $id){
        $banners = [];
        $bills = [];
        $blog = [];
        $contacts = [];
        $help = [];
        $internalmail = [];
        $sendmail = [];
        $shops = [];
        $sitepages = [];
        $site = [];
        $sitemap = [];
        $users = [];
        $bbs = [];
        $seo = [];
        $polls = [];
        $alerts = [];
        $social = [];
        $subscribe = [];
        $promocodes = [];
        $brands = [];
        $rss = [];
        $black_list = [];
        $vacancies = [];
        $vacancy_category = [];
        foreach ($methods as $value){
            switch ($value['module']){
                case 'banners': $banners[] = $value; break;
                case 'bills': $bills[] = $value; break;
                case 'blog': $blog[] = $value; break;
                case 'contacts': $contacts[] = $value; break;
                case 'help': $help[] = $value; break;
                case 'internalmail': $internalmail[] = $value; break;
                case 'sendmail': $sendmail[] = $value; break;
                case 'shops': $shops[] = $value; break;
                case 'site-pages': $sitepages[] = $value; break;
                case 'site': $site[] = $value; break;
                case 'sitemap': $sitemap[] = $value; break;
                case 'users': $users[] = $value; break;
                case 'bbs': $bbs[] = $value; break;
                case 'seo': $seo[] = $value; break;
                case 'polls': $polls[] = $value; break;
                case 'alerts': $alerts[] = $value; break;
                case 'social-networks': $social[] = $value; break;
                case 'subscribers': $subscribe[] = $value; break;
                case 'desktop': $desktop[] = $value; break;

                case 'promocodes': $promocodes[] = $value; break;
                case 'brands': $brands[] = $value; break;
                case 'rss': $rss[] = $value; break;
                case 'black-list': $black_list[] = $value; break;
                case 'vacancies': $vacancies[] = $value; break;
                case 'vacancy-category': $vacancy_category[] = $value; break;
                case 'parser': $parser[] = $value; break;
                default : break;
            }
        }
        return compact(['banners', 'bills', 'blog', 'contacts', 'help', 'internalmail', 'sendmail', 'shops',
            'sitepages', 'sitemap', 'site', 'users', 'bbs', 'polls','seo','alerts','social','subscribe','desktop','parser','id','vacancy_category','vacancies', 'black_list','id','rss','brands','promocodes']);
    }
    public static function saveMethods($methods, $post){
        $comand = Yii::$app->db->createCommand();
        foreach ($methods as $value){
            if (!empty($post[$value['id']])){
                if ($value['value'] != $post[$value['id']] )
                    $comand->update('role_methods', ['value' => 1], ['id' => $value['id']])->execute();
            }else{
                if ($value['value'] == 1 )
                    $comand->update('role_methods', ['value' => 0], ['id' => $value['id']])->execute();
            }
        }
    }
}
