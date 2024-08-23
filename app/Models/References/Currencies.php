<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\Currencies
 * @mixin \Eloquent
 * @mixin IdeHelperCurrencies
 */
class Currencies extends Model
{
    protected $table = 'currencies';
    public $timestamps = false;
    protected $fillable = ['code', 'short_name', 'name', 'rate', 'sorting', 'enabled', 'default'];

    /**
     * Tarjimlar bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translate()
    {
        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(['table_name' => $this->table, 'field_name' => 'name', 'language_code' => app()->getLocale()]);
    }

    /**
     * Pull birliklari ro'yxatini qaytarish
     *
     * @return array
     */
    public static function getList()
    {
        $result = [];
        $curList = Currencies::where(['enabled' => 1])->orderBy('default', 'desc')->get();

        foreach ($curList as $value) {
            $result [] = [
                'id' => $value->id,
                'name' => $value->name,
                'short_name' => $value->short_name,
                'rate' => $value->rate,
            ];
        }
        return $result;
    }

    /**
     * Nomini qaytarish
     *
     * @return mixed
     */
    public function getName()
    {
        $name = $this->name;
        if (app()->getLocale() != Additional::defaultLang()) {
            $translate = $this->translate;
            if ($translate != null) {
                $name = $translate->field_value;
            }
        }
        return $name;
    }
}
