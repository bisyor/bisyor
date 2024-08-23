<?php

namespace backend\models\banners;

use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use backend\models\references\Translates; 
use backend\models\users\Users;

use Yii;

/**
 * This is the model class for table "banners_items".
 *
 * @property int $id
 * @property int|null $banner_id Рекламный баннер
 * @property int|null $type Тип
 * @property string|null $type_data Код
 * @property string|null $img Картинка
 * @property string|null $sitemap_id URL размещения: (относительный UR
 * @property string|null $category_id Не учитывать вложенные страни
 * @property string|null $locale locale
 * @property string|null $url_match url_match
 * @property bool|null $url_match_exact url_match_exact
 * @property string|null $click_url click_url
 * @property string|null $url Ссылка
 * @property string|null $show_start Дата начала
 * @property string|null $show_finish Дата окончани
 * @property int|null $show_limit Количество пока
 * @property string|null $title Наименование реклам
 * @property string|null $description Текст
 * @property string|null $alt Алт
 * @property int|null $enabled Показать или н
 * @property string|null $date_cr Дата создани
 * @property int|null $list_pos list_pos
 * @property bool|null $target_blank Таргет или нет
 * @property int|null $sorting_number Порядковый номер
 * @property int|null $time Время
 * @property string|null $lang_code Язык баннера

 *
 * @property Banners $banner
 */
class BannersItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const TYPE_IMAGE = 1;
    const TYPE_CODE = 3;
    const TYPE_GOOGLE_ADS = 4;
    const DIR_NAME = "banners";
    public $images;
    public static function tableName()
    {
        return 'banners_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['banner_id', 'type', 'show_limit', 'enabled', 'list_pos', 'sorting_number', 'time'], 'default', 'value' => null],
            [['banner_id', 'type', 'show_limit', 'enabled', 'list_pos', 'sorting_number', 'time','sort_type'], 'integer'],
            [['type_data', 'sitemap_id', 'category_id', 'locale', 'url_match', 'click_url', 'description'], 'string'],
            [['url_match_exact', 'target_blank'], 'boolean'],
            [['title'], 'required'],
            [['show_start', 'show_finish', 'date_cr', 'images'], 'safe'],
            [['img', 'url', 'title', 'alt', 'lang_code','keyword'], 'string', 'max' => 255],
            ['sorting_number', 'required', 'when' => function($model) {return $model->sort_type == 2;}, 'enableClientValidation' => false],
            [['banner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Banners::className(), 'targetAttribute' => ['banner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'banner_id' => ' Рекламный баннер',
            'type' => 'Тип',
            'type_data' => 'Код',
            'img' => 'Картинка',
            'sitemap_id' => 'Sitemap ID',
            'category_id' => 'Category ID',
            'locale' => 'Locale',
            'url_match' => ' URL размещения',
            'url_match_exact' => ' Не учитывать вложенные страницы',
            'click_url' => 'Click Url',
            'url' => 'Ссылка',
            'show_start' => 'Дата начала',
            'show_finish' => 'Дата окончание',
            'show_limit' => 'Лимит показов',
            'title' => 'Наименование рекламы',
            'description' => 'Текст',
            'alt' => 'Алт',
            'enabled' => 'Показать',
            'date_cr' => 'Дата создание',
            'list_pos' => 'List Pos',
            'target_blank' => 'Таргет',
            'sorting_number' => 'Порядковый номер',
            'time' => 'Время',
            'lang_code' => 'Язык баннера',
            'sort_type' => 'Тип рекламы',
            'keyword' => 'Кей',
        ];
    }
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->date_cr = date('Y-m-d H:i:s');
        }
        if ($this->show_start) {
            $this->show_start = date('Y-m-d H:i:s', strtotime($this->show_start));
        }
        if ($this->show_finish) {
            $this->show_finish = date('Y-m-d H:i:s', strtotime($this->show_finish));
        }
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        if($this->show_start){
            $this->show_start = date("d.m.Y", strtotime($this->show_start));
        }
        if($this->show_finish){
            $this->show_finish = date("d.m.Y", strtotime($this->show_finish));
        }
        parent::afterFind();
    }
    public function beforeDelete()
    {
        $dir = '/web/uploads/'.self::DIR_NAME.'/';
        $conn_id = Users::connectFtp();
        if($this->img != null){
            if(ftp_size($conn_id, $dir.$this->img) != -1){
                ftp_delete($conn_id, $dir . $this->img);
            }
        }
        return parent::beforeDelete();
    }
    public static function getImageSiteName()
    {
        return Yii::$app->params['image_site'];
    }

    public function search($params, $id)
    {
        $query = BannersItems::find()->where(['banner_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder'=>[
                    'id' => SORT_ASC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'banner_id' => $this->banner_id,
            'type' => $this->type,
            'type_data' => $this->type_data,
            'img' => $this->img,
            'sitemap_id' => $this->sitemap_id,
            'category_id' => $this->category_id,
            'locale' => $this->locale,
            'url_match' => $this->url_match,
            'url_match_exact' => $this->url_match_exact,
            'click_url' => $this->click_url,
            'url' => $this->url,
            'show_start' => $this->show_start,
            'show_finish' => $this->show_finish,
            'show_limit' => $this->show_limit,
            'title' => $this->title,
            'description' =>$this->description,
            'alt' => $this->alt,
            'enabled' => $this->enabled,
            'date_cr' => $this->date_cr,
            'list_pos' => $this->list_pos,
            'target_blank' => $this->target_blank,
            'sorting_number' => $this->sorting_number,
            'time' => $this->time,
        ]);

        return $dataProvider;
    }

    /**
     * Gets query for [[Banner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBanner()
    {
        return $this->hasOne(Banners::className(), ['id' => 'banner_id']);
    }
    /**
     * Gets query for [[BannersStatistics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBannersStatistics()
    {
        return $this->hasMany(BannersStatistic::className(), ['banner_id' => 'id']);
    }

    public function getTypeList()
    {
        return [
            self::TYPE_IMAGE => 'Картинка',
            self::TYPE_CODE => 'Код',
            self::TYPE_GOOGLE_ADS => 'Реклама (Google , Yandex)',
        ];
    }

    public function getSortTypeList()
    {
        return [
            1 => 'Рандом',
            2 => 'Порядковий номер',
        ];
    }


    /**
     * rasm yuklash
     * @return string
     * @throws \yii\db\Exception
     */
    public function upload()
    {
        if(!empty($this->images))
        {
            $dir = '/web/uploads/'.self::DIR_NAME.'/';
            $conn_id = Users::connectFtp();
            if($this->img != null)
            {
                if(ftp_size($conn_id, $dir.$this->img) != -1){
                    ftp_delete($conn_id, $dir . $this->img);
                }
            }
            $fileName = time() . '-' .$this->images->baseName . '.' . $this->images->extension;
            $ftp_path = $dir.$fileName;
            $ret = ftp_nb_put($conn_id, $ftp_path, $this->images->tempName, FTP_BINARY);
            while ($ret == FTP_MOREDATA) {
                $ret = ftp_nb_continue($conn_id);
            }
            if($ret != FTP_FINISHED){
                return "При загрузке файла произошла ошибка...";
            }
            Yii::$app->db->createCommand()->update('banners_items', ['img' => $fileName], [ 'id' => $this->id ])->execute();
        }
    }


    /**
     * rasmni url ni olish
     * @return string
     */
    public function getImgPath()
    {
        if ($this->img == null) {
            return '/backend/web/uploads/noimg.jpg';
        } else {
            return self::getImageSiteName() . "/web/uploads/" . self::DIR_NAME . "/" . $this->img;
        }
    }

    public function getKeyList(){
        return [
            'main_page' => 'Главная страница',
            'shops_list' => 'Магазины (Лист)',
            'items_list' => 'Объявления (Лист)',
            'items_gallery' => 'Объявления (Галерея)',
            'items_map' => 'Объявления (Карта)',
            'items_card_other_items' => 'Карточка объявлении (Другие похожие объявления)',
            'items_card_new_items' => 'Карточка объявлении (Новые объявлении)',
        ];
    }

}
