<?php


namespace App\Models\Items;
use Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Items\ItemsScale
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $description Описание
 * @property string|null $key Ключ
 * @property int|null $status Статус
 * @property float|null $ball Балл
 * @property string|null $minimum_value Минимальная значение
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsScale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsScale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsScale query()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsScale whereBall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsScale whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsScale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsScale whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsScale whereMinimumValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsScale whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsScale whereStatus($value)
 * @mixin \Eloquent
 * @mixin IdeHelperItemsScale
 */
class ItemsScale extends Model
{
    protected $table = 'items_scale';
    public $timestamps = false;

    /**
     * For get image size
     *
     * @param $image
     * @param $size
     * @return bool
     */
    public static function getImageSize($image , $size){
        $itemsPath = config('app.itemsPath');
        $imageSize = get_headers_curl($itemsPath.$image,1);
        if(isset($imageSize['Content-Length']) && ($size <= $imageSize['Content-Length'] / 1024))
            return true;
        return false;
    }


    public static function getHeaderValue($url){
        $arrContextOptions = stream_context_create([
            "ssl"=>[
                "verify_peer"   =>  false,
                "verify_peer_name"  =>  false,
            ],
        ]); 

        return get_headers($url , 1 , $arrContextOptions);
    }
    /**
     * set ball for items
     * @param $model
     */
    public static function setBallItems($model)
    {

        $scale_value = 0;
        $itemsScale = self::where(['status' =>1])->get();
        foreach ($itemsScale as $value){

            // for title
            if($value->key == "title" && ($value->minimum_value <= strlen($model->title)) ){
                $scale_value += $value->ball;
//                $result .= '<br>title =' . $value->ball;
            }

            // for image_quality
            elseif($value->key == "image_quality" && self::getImageSize($model->img_m, $value->minimum_value) ){
                $scale_value += $value->ball;
            }

            // for description
            elseif($value->key == "description" && ($value->minimum_value <= strlen($model->description))){
                $scale_value += $value->ball;
//                $result .= '<br>description =' . $value->ball;
            }


            // for phone
            elseif($value->key == "phone" && $value->minimum_value  <= count($model->getPhones())){
                $scale_value += $value->ball;
//                $result .= '<br>phone =' . $value->ball;
            }


            // for video
            elseif($value->key == "video" && $model->video){
                $scale_value += $value->ball;
//                $result .= '<br>video =' . $value->ball;
            }


            // for image count
            elseif($value->key == "image_count" && $value->minimum_value <= $model->itemImages->count() ){
                $scale_value += $value->ball;
//                $result .= '<br> image count =' . $value->ball;
            }


            // for view count
            elseif($value->key == "view_count" && ($value->minimum_value <= array_sum(array_column( $model->itemViews->toArray(),'item_views')) )){
                $scale_value += $value->ball;
//                $result .= '<br>view count =' . $value->ball;
            }

            // for favorites count
            elseif($value->key == "favorites" && $value->minimum_value <= $model->getItemFavorites->count()){
                $scale_value += $value->ball;
//                $result .= '<br>favorites =' . $value->ball;
            }
        }

        $model->popular_degree = $scale_value;
        $model->save();
    }
}
