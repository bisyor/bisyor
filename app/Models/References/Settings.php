<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\Settings
 *
 * @property int $id
 * @property string|null $name Наименование настройки
 * @property string|null $value Значение
 * @property string|null $key Ключ
 * @property string|null $group Группа
 * @property string|null $type Тип полей
 * @property-read \App\Models\References\Translates $translate
 * @method static \Illuminate\Database\Eloquent\Builder|Settings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings query()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereValue($value)
 * @mixin \Eloquent
 * @mixin IdeHelperSettings
 */
class Settings extends Model
{
    protected $table = 'settings';
    public $timestamps = false;
    protected $fillable = ['name', 'value', 'key'];

    /**
     * Tarjimalar bilan bog'lash
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translate()
    {
        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(['table_name' => $this->table, 'language_code' => app()->getLocale()]);
    }

    /**
     * Kalitga mos qiymatni qaytarish
     *
     * @param $key
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public static function getValueByKey($key)
    {
        $setting = self::where(['key' => $key])->with(['translate'])->first();

        if ($setting != null) {
            $value = $setting->value;
            if (app()->getLocale() != Additional::defaultLang()) {
                $translate = $setting->translate;
                if ($translate != null) {
                    $value = $translate->field_value;
                }
            }

            return $value;
        }
        return trans('messages.Result not found');
    }

}
