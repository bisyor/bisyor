<?php

namespace backend\models\shops;

use Yii;

/**
 * This is the model class for table "shops_comment".
 *
 * @property int $id
 * @property bool|null $enabled Статус
 * @property string|null $text Текст
 * @property int|null $shop_id Магазин
 * @property string|null $user_ip IP пользователья
 * @property string|null $fio Фио пользователья
 *
 * @property Shops $shop
 */
class ShopsComment extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shops_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['enabled'], 'boolean'],
            [['text'], 'string'],
            [['shop_id'], 'default', 'value' => null],
            [['shop_id'], 'integer'],
            [['user_ip', 'fio'], 'string', 'max' => 255],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shops::className(), 'targetAttribute' => ['shop_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'enabled' => 'Статус',
            'text' => 'Текст',
            'shop_id' => 'Магазин',
            'user_ip' => 'IP пользователья',
            'fio' => 'Фио пользователья',
        ];
    }

    /**
     * Gets query for [[Shop]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shops::className(), ['id' => 'shop_id']);
    }

    public static function getStatus(): array
    {
        return [self::STATUS_ACTIVE => 'Активно', self::STATUS_INACTIVE => 'Не активно'];
    }

    public static function getStatusName($status = null): string
    {
        return ($status == self::STATUS_ACTIVE) ?
            '<span class="label label-success"> Активно </span>'
            : '<span class="label label-danger">Не активно</span>';
    }
}
