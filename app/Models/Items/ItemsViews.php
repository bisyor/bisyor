<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Eloquent
 * @mixin Builder
 * @mixin IdeHelperItemsViews
 */
class ItemsViews extends Model
{
    protected $table = 'items_views';
    public $timestamps = false;
    protected $fillable = ['item_id', 'item_views', 'contacts_views', 'period'];

    /**
     * Elonlarni ko'rishlar sonini oshirish
     *
     * @param $item_id
     * @param $type
     */
    public static function setViewCount($item_id, $type)
    {
        $itemView = ItemsViews::where(['item_id' => $item_id, 'period' => date('Y-m-d')])->first();
        if ($itemView == null) {
            $itemView = new ItemsViews();
            $itemView->item_id = $item_id;
            $itemView->contacts_views = 0;
            $itemView->item_views = 0;
            if ($type == 1) {
                $itemView->item_views = 1;
            } else {
                $itemView->contacts_views = 1;
            }
            $itemView->period = date('Y-m-d');
            $itemView->save();
        } else {
            if ($type == 1) {
                $itemView->item_views += 1;
            } else {
                $itemView->contacts_views += 1;
            }
            $itemView->save();
        }
    }

    /**
     * E'lon ko'rishlar sonini o'chirish
     *
     * @param $item_id
     * @return mixed
     */
    public static function clearViewCount($item_id)
    {
        return ItemsViews::where(['item_id' => $item_id])->update(['item_views' => 0]);
    }

    /**
     * Qo'ng'iroqlarni reset qilish uchun funksiya
     *
     * @param $item_id
     * @return mixed
     */
    public static function clearContactCount($item_id)
    {
        return ItemsViews::where(['item_id' => $item_id])->update(['contacts_views' => 0]);
    }

    /**
     * @param Items $item
     * @param int $back_days
     * @return array
     */
    public static function getStatByDate(Items $item, int $back_days){
        $item_views_stats = ItemsViews::where('item_id', $item->id)
            ->whereBetween('period', [now()->subDays($back_days)->format('Y-m-d'), now()->format('Y-m-d')])
            ->get(['item_views', 'contacts_views', 'period'])->keyBy('period')->toArray();
        $results = [];
        for($i = $back_days - 1; $i >= 0; $i--){
            $current_loop_date = now()->subDays($i)->format('Y-m-d');
            if(!array_key_exists($current_loop_date, $item_views_stats)){
                array_push($results,['item_views' => 0, 'contacts_views' => 0, 'period' => $current_loop_date]);
            }else{
                array_push($results, $item_views_stats[$current_loop_date]);
            }
        }

        return $results;
    }

}
