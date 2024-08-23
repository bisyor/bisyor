<?php

namespace backend\models\references;

use Yii;
use yii\imagine\Image;

/**
 * This is the model class for table "bonus_list".
 *
 * @property int $id
 * @property string|null $title Заголовок
 * @property string|null $description Описания
 * @property int|null $status Статус
 * @property string|null $image Картинка
 * @property float|null $bonus Бонус
 * @property string|null $keyword Кей
 *
 * @property BonusHistory[] $bonusHistories
 */
class BonusList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $images;
    const DIR = 'bonus_list';
    public static function tableName()
    {
        return 'bonus_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
            [['bonus'], 'number'],
            [['images'],'safe'],
            [['bonus','title','keyword'],'required'],
            [['title', 'image', 'keyword'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Описания',
            'status' => 'Статус',
            'image' => 'Картинка',
            'images' => 'Картинка',
            'bonus' => 'Бонус',
            'keyword' => 'Кей',
        ];
    }

    /**
     * Gets query for [[BonusHistories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBonusHistories()
    {
        return $this->hasMany(BonusHistory::className(), ['bonus_id' => 'id']);
    }


    /**
     * @return bool
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
     * @return string
     */
    public function getAvatar()
    {
        if ($this->image == '') {
            return '/backend/web/uploads/noimg.jpg';
        } else {
            return self::getImageSiteName().'/web/uploads/'.self::DIR.'/'.$this->image;
        }
    }


    /**
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
            $ftp_path = $dir.$fileName;
            $ret = ftp_nb_put($conn_id, $ftp_path, $this->images->tempName, FTP_BINARY);
            while ($ret == FTP_MOREDATA) {
                $ret = ftp_nb_continue($conn_id);
            }
            if($ret != FTP_FINISHED){
                return "При загрузке файла произошла ошибка...";
            }
            Yii::$app->db->createCommand()->update('bonus_list', ['image' => $fileName],
                [ 'id' => $this->id ])->execute();
        }
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
     * @return false|resource
     */
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

    public static function getStatusName($status = null)
    {
        return ($status == 1) ? '<span class="text-success text-muted">Активно</span>' : '<span class="text-danger text-muted">Не активно</span>';
    }
}
