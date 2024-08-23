<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Items\ItemsImages
 *
 * @property int $id
 * @property int|null $item_id
 * @property int|null $user_id
 * @property string|null $filename
 * @property string|null $created
 * @property int|null $width
 * @property int|null $height
 * @property int|null $num
 * @property string|null $extstor_img_s
 * @property string|null $extstor_img_m
 * @property string|null $extstor_img_v
 * @property string|null $extstor_img_z
 * @property string|null $extstor_img_o
 * @property string|null $img_prefix
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages query()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages whereExtstorImgM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages whereExtstorImgO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages whereExtstorImgS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages whereExtstorImgV($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages whereExtstorImgZ($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages whereImgPrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsImages whereWidth($value)
 * @mixin \Eloquent
 * @mixin IdeHelperItemsImages
 */
class ItemsImages extends Model
{
    protected $table = 'items_images';
    public $timestamps = false;
    protected $fillable = [
        'item_id',
        'user_id',
        'filename',
        'created',
        'width',
        'height',
        'extstor_img_s',
        'extstor_img_m',
        'extstor_img_v',
        'extstor_img_z',
        'extstor_img_o',
        'img_prefix'
    ];

    /**
     * Mini turidagi rasmlarni qaytarish
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function imageS()
    {
        if ($this->extstor_img_s == null || $this->extstor_img_s == '') {
            return config('app.noImage');
        }
        return config('app.itemsPath') . $this->extstor_img_s;
    }

    /**
     * Kichik hajmli turidagi rasmlarni qaytarish
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function imageM()
    {
        if ($this->extstor_img_m == null || $this->extstor_img_m == '') {
            return config('app.noImage');
        }
        return config('app.itemsPath') . $this->extstor_img_m;
    }

    /**
     * Hajmi siqilgan rasmni sayt logosi yopishtirilgani
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function imageV()
    {
        if ($this->extstor_img_v == null || $this->extstor_img_v == '') {
            return config('app.noImage');
        }
        return config('app.itemsPath') . $this->extstor_img_v;
    }

    /**
     * Orginal rasmni hajmi siqilgan xoldagisi
     * Agar ular mavjud bo'lmasa bo'sh rasm qaytariladi (noimage)
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function imageZ()
    {
        if ($this->extstor_img_z == null || $this->extstor_img_z == '') {
            return config('app.noImage');
        }
        return config('app.itemsPath') . $this->extstor_img_z;
    }

    /**
     * Orginal rasmlarni qaytarish
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function imageO()
    {
        if ($this->extstor_img_o == null || $this->extstor_img_o == '') {
            return config('app.noImage');
        }
        return config('app.itemsPath') . $this->extstor_img_o;
    }
}
