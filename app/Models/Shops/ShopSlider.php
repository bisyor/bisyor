<?php

namespace App\Models\Shops;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Shops\ShopSlider
 *
 * @property int $id
 * @property int|null $shop_id Магазин
 * @property string|null $title Заголовок
 * @property string|null $text Текст
 * @property string|null $image Картинка
 * @property string|null $link Ссылка
 * @property-read \App\Models\Shops\Shops $shops
 * @mixin IdeHelperShopSlider
 */
class ShopSlider extends Model
{
    protected $table = 'shop_slider';
    public $timestamps = false;
    protected $fillable = ['shop_id', 'title', 'text', 'image', 'link'];

    public function shops()
    {
        return $this->belongsTo('App\Models\Shops\Shops', 'shop_id', 'id');
    }

    /**
     * Rasmni olish
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function getImage()
    {
        if ($this->image == null || $this->image == '') {
            return config('app.noImage');
        }
        return config('app.uploadPath') . 'shop-slider/' . $this->image;
    }

    /**
     * Rasmni yuklash
     *
     * @param $file
     */
    public function setImage($file)
    {
        $uploadPath = config('app.sliderShopsRoute');
        $old_path = config('app.trashRoute');
        Storage::disk('ftp')->move($old_path . $file, $uploadPath . $file);
        $this->image = $file;
    }

    /**
     * Maalumotlarni saqlab olish
     *
     * @param $data
     * @param null $shop
     */
    public function setData($data, $shop = null)
    {
        $this->title = $data['title'];
        $this->text = $data['text'];
        if ($shop) {
            $this->shop_id = $shop;
        }
        $this->link = $data['link'];
        $this->title = $data['title'];
        if ($data['temp_address']) {
            $this->setImage($data['temp_address']);
        }
        $this->save();
    }
}
