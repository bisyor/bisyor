<?php

namespace backend\models\blogs;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use backend\models\references\Translates;
use backend\models\references\Districts;
use backend\models\users\Users;
use yii\imagine\Image;

use Yii;

/**
 * This is the model class for table "blog_posts".
 *
 * @property int $id
 * @property int|null $blog_categories_id Категория
 * @property string|null $title Наименование
 * @property string|null $slug Слуг
 * @property string|null $image Картинка
 * @property string|null $image_m Мини картинка
 * @property int|null $status Статус
 * @property string|null $short_text Короткое Описание
 * @property string|null $text Текст
 * @property string|null $date_cr Дата создании
 * @property int|null $view_count Количество просмотров
 * @property int|null $user_id Пользователь
 *
 * @property BlogPostTags[] $blogPostTags
 * @property BlogCategories $blogCategories
 * @property Users $user
 * @property BlogsPostsLikes[] $blogsPostsLikes
 */

class BlogPosts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const ACTIVE_STATUS = 1;
    const NO_ACTIVE_STATUS = 0;
    const DIR = 'blog_posts';
    public $translation_name;
    public $translation_short_text;
    public $translation_text;
    public $images;
    public $tags;

    public static function tableName()
    {
        return 'blog_posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blog_categories_id', 'status', 'view_count', 'user_id'], 'default', 'value' => null],
            [['blog_categories_id', 'status', 'view_count', 'user_id'], 'integer'],
            [['short_text', 'text'], 'string'],
            [['date_cr'], 'safe'],
            [['title', 'blog_categories_id'], 'required'],
            [['translation_name', 'translation_short_text', 'translation_text'],'safe'],
            [['title', 'slug', 'image', 'image_m'], 'string', 'max' => 255],
            [['images'], 'safe'],
            [['images'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, ico,',],
            [['blog_categories_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogCategories::className(), 'targetAttribute' => ['blog_categories_id' => 'id']],
            ['tags' , 'validateTags'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'skeeks\yii2\slug\SlugBehavior',
                'slugAttribute' => 'slug',                       
                'attribute' => 'title',                        
                'maxLength' => 64,         
                'minLength' => 3,          
                'ensureUnique' => true,
                'slugifyOptions' => [
                    'lowercase' => true,
                    'separator' => '-',
                    'trim' => true,
                    'rulesets' => ['russian'],
                ]
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blog_categories_id' => 'Категория',
            'title' => 'Заголовок',
            'slug' => 'Ссылка блога',
            'image' => 'Картинка',
            'status' => 'Статус',
            'short_text' => 'Короткое описание',
            'text' => 'Текст',
            'date_cr' => 'Дата создании',
            'view_count' => 'Количество просмотров',
            'user_id' => 'Создатель',
            'tags' => 'Теги',
        ];
    }

    public function validateTags($attribute, $params)
    {   
        $res = [];
        $tags = BlogTags::find()->select('id')->asArray()->all();
        foreach ($tags as $key => $value) {
            $res [] = $value['id'];
        }
        $array = array_diff($this->tags , $res);
        if($array){
            foreach ($array as $key => $value) {
                $model = new BlogTags();            
                $model->name = $value; 
                if ($model->save()){
                }else{
                    $this->addError($attribute,"Не создан новый группа товары");
                    echo "<pre>".print_r($model,true)."</pre>";
                }
            }

        }
    }


    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->date_cr = date("Y-m-d H:i");
            $this->user_id = Yii::$app->user->identity->id;
        }
        
        return parent::beforeSave($insert);
    }

    /**
     * This method is invoked before deleting a record.
     * @return bool whether the record should be deleted. Defaults to `true`.
     */
    public function beforeDelete()
    {
        $dir = '/web/uploads/'.self::DIR.'/';
        $conn_id = self::connectFtp();
        if($this->image != null){
            if(ftp_size($conn_id, $dir.$this->image) != -1){
                ftp_delete($conn_id, $dir . $this->image);
            }
        }
        return parent::beforeDelete();
    }

    /**
     * Gets query for [[BlogPostTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogPostTags()
    {
        return $this->hasMany(BlogPostTags::className(), ['blog_posts_id' => 'id']);
    }

    /**
     * Gets query for [[BlogCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogCategories()
    {
        return $this->hasOne(BlogCategories::className(), ['id' => 'blog_categories_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[BlogsPostsLikes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogsPostsLikes()
    {
        return $this->hasMany(BlogsPostsLikes::className(), ['blog_posts_id' => 'id']);
    }


    /**
     * @return string[]
     */
    public static function NeedTranslation()
    {
        return [
            'title' => 'translation_name',
            'short_text' => 'translation_short_text',
            'text' => 'translation_text',
        ];
    }
    public static function connectFtp()
    {
        $host = Yii::$app->params['host'];
        //host
        $name = $host['name'];
        $usr = $host['username'];
        $pwd = $host['password'];

        // connect to FTP server (port 21)
        $conn_id = ftp_connect($name, 21) or die ("Cannot connect to host");
        // send access parameters
        if(ftp_login($conn_id, $usr, $pwd)){
            ftp_pasv($conn_id, true);
            return $conn_id;
        }
    }


    /**
     * categoryani listini olish
     * @return array
     */
    public static function getCategoriesList()
    {
        $categories = BlogCategories::find()->all();
        return ArrayHelper::map($categories, 'id', 'name');
    }


    /**
     * image sita url
     * @return mixed
     */
    public static function getImageSiteName()
    {
        return Yii::$app->params['image_site'];
    }


    /**
     * imgni url ni olish
     * @return string
     */
    public function getImgPath()
    {
        if ($this->image == null) {
            return '/backend/web/uploads/noimg.jpg';
        } else {
            return self::getImageSiteName().'/web/uploads/'.self::DIR.'/'.$this->image;
        }
    }


    /**
     * avartni urlni olish
     * @return string
     */
    public function getAvatar()
    {
        if(!$this->image_m == ''){
            return self::getImageSiteName().'/web/uploads/'.self::DIR.'/'.$this->image_m;
        }
        if ($this->image == '') {
            return '/backend/web/uploads/noimg.jpg';
        } else {
            return self::getImageSiteName().'/web/uploads/'.self::DIR.'/'.$this->image;
        }
    }


    /**
     * status name
     * @return string
     */
    public function getStatusName()
    {
        if($this->status == self::ACTIVE_STATUS) return 'Активно';
        else return 'Не активно';
    }


    /**
     * status list
     * @return string[]
     */
    public static function getStatusList()
    {
        return [
            self::ACTIVE_STATUS => 'Активно',
            self::NO_ACTIVE_STATUS => 'Не активно'
        ];
    }


    /**
     * tag list
     * @return array
     */
    public function getTagsList()
    {
        $tags = BlogTags::find()->all();
        return ArrayHelper::map($tags, 'id', 'name');
    }


    /**
     * image yuklash
     * @return string
     * @throws \yii\db\Exception
     */
    public function upload()
    {
        if(!empty($this->images))
        {   $dir = '/web/uploads/'.self::DIR.'/';
            $conn_id = self::connectFtp();
            if( $this->image != null){
                if(ftp_size($conn_id, $dir.$this->image) != -1){
                    ftp_delete($conn_id, $dir . $this->image);
                }
            }
            $fileName =  time() . '_' . $this->images->baseName . '.' . $this->images->extension;
            $file_name_m =  time() . '_' . $this->images->baseName . '-m.' . $this->images->extension;
            $ftp_path = $dir.$fileName;
            $ret = ftp_nb_put($conn_id, $ftp_path, $this->images->tempName, FTP_BINARY);
            while ($ret == FTP_MOREDATA) {
                $ret = ftp_nb_continue($conn_id);
            }
            if($ret != FTP_FINISHED){
                return "При загрузке файла произошла ошибка...";
            }
            list($sizeWidth, $sizeHeight) = getimagesize(self::getImageSiteName() . $ftp_path);
            if($sizeWidth > 550){
                $x = 550;
            } else $x = $sizeWidth;
            if($sizeHeight > 350){
                $y = 350;
            } else $y = $sizeHeight;
            $image = Image::thumbnail(self::getImageSiteName() . $ftp_path, $x, $y)
                ->get($this->images->extension);
            $ret = ftp_nb_put($conn_id, $dir . $file_name_m, "data:image/jpeg;base64," . base64_encode($image), FTP_BINARY);
            while ($ret == FTP_MOREDATA) {
                $ret = ftp_nb_continue($conn_id);
            }
            if($ret != FTP_FINISHED){
                return "При загрузке файла произошла ошибка...";
            }
            Yii::$app->db->createCommand()->update('blog_posts', ['image' => $fileName, 'image_m' => $file_name_m],
                [ 'id' => $this->id ])->execute();
        }
    }


    /**
     * date cr olish
     * @return false|string
     */
    public function getDateCr()
    {
        return date('H:i d.m.Y', strtotime($this->date_cr) );
    }


    /**
     * slug link
     * @return string
     */
    public function getSlugLink()
    {        
        $site_name = Yii::$app->params['site_name'];
        return $site_name . '/blogs/' . $this->slug;
    }


    /**
     * tagni blogga biriktirish
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function setPostTags()
    {   

        BlogPostTags::deleteAll(['blog_posts_id' => $this->id]);

        $idTags = [];
        if($this->tags){
            foreach ($this->tags as $key => $value) {
               if(is_numeric($value)) $idTags [] = $value;
            }
        }
        $blog_tags = BlogTags::find()
                        ->andWhere(['or',
                            ['id' => $idTags],
                            ['name' => $this->tags]
                        ])
                      ->all();
        if($blog_tags)
        {
            foreach ($blog_tags as $key => $value) {
                $tags = new BlogPostTags();
                $tags->blog_posts_id = $this->id;
                $tags->tag_id = $value->id;
                $tags->save();
            }
        }
    }


    /**
     * taglar listini olish
     * @return array
     */
    public function getTags()
    {
        $tags = BlogPostTags::find()->where(['blog_posts_id' => $this->id])->all();
        $result = [];
        if($tags != null){
            foreach ($tags as $key => $value) {
                $result [] = $value->tag_id;
            }
        }
        return $result;
    }
}
