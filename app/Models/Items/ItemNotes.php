<?php


namespace App\Models\Items;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Items\ItemNotes
 *
 * @property int $id
 * @property int|null $item_id Объявления
 * @property int|null $user_id Пользователи
 * @property string|null $message Текст
 * @method static \Illuminate\Database\Eloquent\Builder|ItemNotes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemNotes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemNotes query()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemNotes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemNotes whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemNotes whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemNotes whereUserId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperItemNotes
 */
class ItemNotes extends Model
{
    public $timestamps = false;
    protected $table = 'items_note';
    protected $fillable = ['item_id', 'user_id', 'message'];
}
