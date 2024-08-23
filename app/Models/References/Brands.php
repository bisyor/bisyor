<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\Brands
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property int|null $sorting Сортировка
 * @property bool|null $enabled Вкл/Откл
 * @property string|null $image Картинка
 * @method static \Illuminate\Database\Eloquent\Builder|Brands newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brands newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brands query()
 * @method static \Illuminate\Database\Eloquent\Builder|Brands whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brands whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brands whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brands whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brands whereSorting($value)
 * @mixin \Eloquent
 * @mixin IdeHelperBrands
 */
class Brands extends Model
{
    protected $table = 'brands';
    public $timestamps = false;
    protected $fillable = ['name', 'sorting', 'enabled', 'image'];

    /**
     * Brend logosini olish
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function getLogo()
    {
        if ($this->image == null || $this->image == '') {
            return config('app.noImage');
        }
        return config('app.uploadPath') . 'brands/' . $this->image;
    }

}
