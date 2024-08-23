<?php

namespace App\Models\Blogs;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Blogs\BlogsPostsLikes
 *
 * @property int $id
 * @property int|null $blog_posts_id Блог
 * @property int|null $type Тип
 * @property int|null $user_id Пользователь
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|BlogsPostsLikes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogsPostsLikes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogsPostsLikes query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogsPostsLikes whereBlogPostsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogsPostsLikes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogsPostsLikes whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogsPostsLikes whereUserId($value)
 * @mixin IdeHelperBlogsPostsLikes
 */
class BlogsPostsLikes extends Model
{
    protected $table = 'blogs_posts_likes';
    public $timestamps = false;
    protected $fillable = ['blog_posts_id', 'type', 'user_id'];

}
