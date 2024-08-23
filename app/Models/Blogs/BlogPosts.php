<?php

namespace App\Models\Blogs;

use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\References\Translates;
use App\Models\Chats\Chats;
use App\Models\References\Additional;
use App\Models\References\Seo;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Blogs\BlogPosts
 *
 * @property int $id
 * @property int|null $blog_categories_id Категория
 * @property string|null $title Наименование
 * @property string|null $slug Слуг
 * @property string|null $image Картинка
 * @property int|null $status Статус
 * @property string|null $short_text Короткое Описание
 * @property string|null $text Текст
 * @property string|null $date_cr Дата создании
 * @property int|null $view_count Количество просмотров
 * @property int|null $user_id Пользователь
 * @property string|null $image_m
 * @property-read \App\Models\Blogs\BlogCategories|null $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|Chats[] $msgCount
 * @property-read int|null $msg_count_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Translates[] $translates
 * @property-read int|null $translates_count
 * @property-read \App\User|null $users
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|Chats[] $likes
 * @property-read int|null $likes_count
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPosts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPosts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPosts query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPosts whereBlogCategoriesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPosts whereDateCr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPosts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPosts whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPosts whereImageM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPosts whereShortText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPosts whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPosts whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPosts whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPosts whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPosts whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPosts whereViewCount($value)
 * @mixin IdeHelperBlogPosts
 */
class BlogPosts extends Model
{
    protected $table = 'blog_posts';
    public $timestamps = false;
    protected $fillable = [
        'blog_categories_id',
        'title',
        'slug',
        'image',
        'status',
        'short_text',
        'text',
        'date_cr',
        'view_count',
        'user_id'
    ];

    /**
     * Kategoriyalar bilan bog'lanish
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->belongsTo('App\Models\Blogs\BlogCategories', 'blog_categories_id', 'id');
    }

    /**
     * Blogga biriktirilgan xabarlar soni
     * @return mixed
     */
    public function msgCount()
    {
        return $this->hasMany('App\Models\Chats\Chats', 'field_id', 'id')
            ->with(['chatMessagesCount'])
            ->where(['type' => 3])->take(1);
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Chats\Chats', 'field_id', 'id')
            ->with(['chatMessagesCount'])
            ->where(['type' => 3])->take(1);
    }

    /**
     * Foydalanuvchilar jadvali bilan bog'lanish
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Tarjimalar bilan bog'lanish
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translates()
    {
        return $this->hasMany(Translates::class, 'field_id', 'id')->where(
            ['table_name' => $this->table, 'language_code' => app()->getLocale()]
        );
    }

    /**
     * Rasmlarni qaytaruvchi
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    // public function getImage()
    // {
    //     if ($this->image == null || $this->image == '') {
    //         return config('app.noImage');
    //     } else {
    //         return config('app.blogsPath') . $this->image;
    //     }
    // }
    
    
     public function getImage()
    {   
        $size_folder = '600x400';
       if ($this->image == null || $this->image == '') {
            return config('app.noImage');
        } else {
           
            $image = $this->image;

            try{
                $fileName = md5($image).'.webp';
                $path = storage_path().'/app/public/'.$size_folder;
                if (file_exists($path.'/'.$fileName)) {
                    return  env('SITE_LINK'). '/storage/'.$size_folder.'/'.$fileName;
                }

                File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
                $img = Image::make(config('app.blogsPath') . $image);
                $img->resize(600, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save($path."/".$fileName, 90);
                return  env('SITE_LINK'). '/storage/'.$size_folder.'/'.$fileName; 
            }catch(\Exception $e){
                return config('app.noImage');
            }
        }
    }
    

    /**
     * Kichik rasmlarni qaytarish
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function getImageM()
    {
        if ($this->image_m !== null || !$this->image_m == '') {
            return config('app.blogsPath') . $this->image_m;
        }
        if ($this->image == null || $this->image == '') {
            return config('app.noImage');
        } else {
            return config('app.blogsPath') . $this->image;
        }
    }

    /**
     * Postlarni olish
     * @param string $type
     * @return array
     */
    public function getPost($type = 'card')
    {
        $title = $this->title;
        $short_text = $this->short_text;
        $text = $this->text;

        if (app()->getLocale() != Additional::defaultLang()) {
            $postTranslate = $this->translates;
            if ($postTranslate != null) {
                foreach ($postTranslate as $value) {
                    if (isset($value->field_name) && $value->field_name == 'title' && $value->field_value != '') {
                        $title = $value->field_value;
                    }
                    if (isset($value->field_name) && $value->field_name == 'short_text' && $value->field_value != '') {
                        $short_text = $value->field_value;
                    }
                    if (isset($value->field_name) && $value->field_name == 'text' && $value->field_value != '') {
                        $text = $value->field_value;
                    }
                }
            }
        }

        $fav = 0;
        if ($type == 'card') {
            $user = Auth::user();
            if ($user != null) {
                $likes = BlogsPostsLikes::where(['user_id' => $user->id, 'blog_posts_id' => $this->id])->first();
                if ($likes == null) {
                    $fav = 0;
                } else {
                    $fav = 1;
                }
            }else{
                $fav = Cookie::get("blog_likes_$this->id");
            }
        }

        return [
            'id' => $this->id,
            'title' => $title,
            'slug' => $this->slug,
            'image' => $this->getImage(),
            'image_m' => $this->getImageM(),
            'status' => $this->status,
            'short_text' => $short_text,
            'text' => $text,
            'favorite' => $fav,
            'date_cr' => date('d.m.Y', strtotime($this->date_cr)),
            'view_count' => $this->view_count,
            'user_id' => $this->user_id,
            'userFio' => $this->users->getUserFio(),
            'userAvatar' => $this->users->getAvatar(),
            'msgCount' => count($this->msgCount) > 0 ? $this->msgCount[0]->chatMessagesCount->count() : 0,
            'catName' => $this->categories->name,
        ];
    }

    /**
     * Postlarga qo'yilgan likelarni olish
     * @param $blog
     * @return array
     */
    public static function getLikePosts($blog)
    {
        $blogs = BlogPosts::where('title', 'like', '%' . $blog->title . '%')->where('id', '!=', $blog->id)
            ->with(['translates', 'users', 'categories'])->get()->take(4);
        $result = [];
        foreach ($blogs as $value) {
            $result [] = $value->getPost();
        }
        return $result;
    }

    /**
     * Topdagi postni qaytarish
     * @param string $type
     * @return null
     */
    public static function getTopPost($type = 'card')
    {
        $blog = BlogPosts::with(['translates', 'users', 'categories', 'msgCount'])
            ->orderBy('view_count', 'desc')->first();

        if ($blog != null) {
            return $blog->getPost($type);
        }
        return null;
    }

    /**
     * Topdagi postlarni olish
     * @return array
     */
    public static function getTopPosts()
    {
        $blogs = BlogPosts::with(['translates', 'users', 'categories', 'msgCount'])
            ->orderBy('view_count', 'desc')->get()->take(4);
        $result = [];
        foreach ($blogs as $value) {
            $result [] = $value->getPost();
        }
        return $result;
    }

    /**
     * Yangi bloglarni olish
     * @param string $type
     * @return array
     */
    public static function getNewBlogs($type = 'card')
    {
        $blogs = BlogPosts::with(['translates', 'users', 'categories', 'msgCount'])
            ->orderBy('id', 'desc')->get()->take(5);

        $result = [];
        foreach ($blogs as $value) {
            $result [] = $value->getPost($type);
        }
        return $result;
    }

}
