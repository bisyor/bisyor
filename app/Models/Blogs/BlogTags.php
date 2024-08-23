<?php

namespace App\Models\Blogs;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Blogs\BlogTags
 *
 * @property int $id
 * @property string|null $name Наименование
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTags newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTags query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTags whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTags whereName($value)
 * @mixin IdeHelperBlogTags
 */
class BlogTags extends Model
{
	protected $table = 'blog_tags';
	public $timestamps = false;
	protected $fillable = ['name'];
}
