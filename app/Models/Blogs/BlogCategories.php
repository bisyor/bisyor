<?php

namespace App\Models\Blogs;

use App\Models\References\Translates;
use App\Models\References\Additional;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Blogs\BlogCategories
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $key Ключ
 * @property int|null $sorting Сортировка
 * @property string|null $date_cr Дата создание
 * @property bool|null $enabled Статус
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Blogs\BlogPosts[] $posts
 * @property-read int|null $posts_count
 * @property-read Translates $translate
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|BlogCategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogCategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogCategories query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogCategories whereDateCr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogCategories whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogCategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogCategories whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogCategories whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogCategories whereSorting($value)
 * @mixin IdeHelperBlogCategories
 */
class BlogCategories extends Model
{
    protected $table = 'blog_categories';
    public $timestamps = false;
    protected $fillable = ['key', 'sorting', 'name', 'date_cr', 'enabled'];

    /**
     * Blog kategoriyalarni postlar bilan bog'lash
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(BlogPosts::class, 'blog_categories_id', 'id')
            ->where(['status' => 1])->with(['users', 'categories', 'msgCount'])
            ->orderBy('date_cr', 'desc');
    }

    /**
     * Tarjimalar bilan bog'lanish
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translate()
    {
        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(['table_name' => $this->table, 'field_name' => 'name', 'language_code' => app()->getLocale()]);
    }

    /**
     * Kategoriyaar listini qaytarish
     * @return array
     */
    public static function getCategoriesList()
    {
        $categories = BlogCategories::where('key', '!=', 'root')->where(['enabled' => 1])->with(
            ['posts', 'translate']
        )->orderBy('sorting', 'asc')->get();
        $result = [];

        foreach ($categories as $category) {
            $result [] = $category->getCategoryValues('postsLimit');
        }
        return $result;
    }

    /**
     * Kategoriyani qaytarish
     * @return array
     */
    public function getCategory()
    {
        $catTrValue = Translates::where(
            [
                'table_name' => 'blog_categories',
                'field_id' => $this->id,
                'field_name' => 'name',
                'language_code' => app()->getLocale()
            ]
        )->first();

        return [
            'id' => $this->id,
            'key' => $this->key,
            'name' => $catTrValue == null ? $this->name : $catTrValue->field_value,
            'date_cr' => $this->date_cr,
        ];
    }

    /**
     * Kategoriyalar nomini olish
     * @return array
     */
    public static function getCategoriesNames()
    {
        $categories = BlogCategories::where('key', '!=', 'root')->where(['enabled' => 1])->with(
            ['posts', 'translate']
        )->orderBy('sorting', 'asc')->get();
        $result = [];

        foreach ($categories as $category) {
            $name = $category->name;
            if (app()->getLocale() != Additional::defaultLang()) {
                $translate = $category->translates;
                if ($translate != null) {
                    $name = $translate->field_value;
                }
            }

            $result [] = [
                'id' => $category->id,
                'key' => $category->key,
                'name' => $name,
                'date_cr' => $category->date_cr,
            ];
        }
        return $result;
    }

    /**
     * Kategoriyani qiymatini olish
     * @param $postListType
     * @return array
     */
    public function getCategoryValues($postListType)
    {
        if ($postListType == 'posts') {
            $posts = $this->posts;
        } else {
            $posts = $this->posts->take(4);
        }
        $blogResult = [];

        foreach ($posts as $post) {
            $blogResult [] = $post->getPost();
        }
        $name = $this->name;
        if (app()->getLocale() != Additional::defaultLang()) {
            $translate = $this->translate;
            if ($translate != null) {
                $name = $translate->field_value;
            }
        }

        return [
            'id' => $this->id,
            'key' => $this->key,
            'name' => $name,
            'date_cr' => $this->date_cr,
            'postCount' => count($posts),
            'blogList' => $blogResult,
        ];
    }

}
