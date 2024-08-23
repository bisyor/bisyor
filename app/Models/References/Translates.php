<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\Translates
 *
 * @property int $id
 * @property string|null $table_name Наименование таблицы
 * @property int|null $field_id ID строка
 * @property string|null $field_name Наименование строка
 * @property string|null $field_value Значение
 * @property string|null $language_code Код языка
 * @method static \Illuminate\Database\Eloquent\Builder|Translates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translates query()
 * @method static \Illuminate\Database\Eloquent\Builder|Translates whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translates whereFieldName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translates whereFieldValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translates whereLanguageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translates whereTableName($value)
 * @mixin \Eloquent
 * @mixin IdeHelperTranslates
 */
class Translates extends Model
{
	public $timestamps = false;

	protected $fillable = ['table_name', 'field_id', 'field_name', 'field_value', 'language_code'];
}
