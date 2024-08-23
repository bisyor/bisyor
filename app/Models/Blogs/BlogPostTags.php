<?php

namespace App\Models\Blogs;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Blogs\BlogPostTags
 *
 * @property int $id
 * @property int|null $blog_posts_id Блог
 * @property int|null $tag_id Тег
 * @property-read \App\Models\Blogs\BlogPosts|null $post
 * @property-read \App\Models\Blogs\BlogTags|null $tag
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPostTags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPostTags newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPostTags query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPostTags whereBlogPostsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPostTags whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPostTags whereTagId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperBlogPostTags
 */
class BlogPostTags extends Model
{
	protected $table = 'blog_post_tags';
	public $timestamps = false;
	protected $fillable = ['blog_posts_id', 'tag_id'];

	public function tag()
	{
	    return $this->belongsTo('App\Models\Blogs\BlogTags', 'tag_id', 'id');
	}

	public function post()
	{
	    return $this->belongsTo('App\Models\Blogs\BlogPosts', 'blog_posts_id', 'id');
	}

}
