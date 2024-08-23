<?php

namespace App\Http\Controllers\Blogs;

use Auth;
use App\Models\Blogs\BlogCategories;
use App\Models\Blogs\BlogsPostsLikes;
use App\Models\Blogs\BlogPosts;
use App\Models\Blogs\BlogPostTags;
use App\Models\Banners\Banners;
use App\Models\Chats\ChatMessage;
use App\Models\Chats\Chats;
use App\Models\References\Seo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\References\Additional;
use Illuminate\Support\Facades\Cookie;

class BlogsController extends Controller
{
    /**
     * Bloglar listini qaytarish funksiyasi
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request)
    {
        $categories = BlogCategories::getCategoriesList();
        $topPosts = BlogPosts::getTopPosts();
        $langs = Additional::getLangs();
        $segmants = Additional::getUrlSegmants(request()->segments());
        $seo = Seo::getMetaBlogList(Seo::getSeoKey('blogs', app()->getLocale()), app()->getLocale());
        return view(
            'blogs.list',
            [
                'segmants' => $segmants,
                'categories' => $categories,
                'topPosts' => $topPosts,
                'langs' => $langs,
                'seo' => $seo
            ]
        );
    }

    /**
     * Bloglarni kategoriyalar bo'yicha olish
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(Request $request)
    {
        $cat = BlogCategories::where(['key' => $request->categoryKey])->first();
        $categoryValues = $cat->getCategoryValues('posts');
        $categoriesNames = BlogCategories::getCategoriesNames();
        $seo = Seo::getMetaBlogCat(
            Seo::getSeoKey('blogs', app()->getLocale()),
            $categoryValues['name'],
            app()->getLocale()
        );

        return view(
            'blogs.category',
            [
                'categoryValues' => $categoryValues,
                'categoriesNames' => $categoriesNames,
                'cat' => $cat,
                'seo' => $seo,
            ]
        );
    }

    /**
     * Har bir blogni ko'rish oynasi
     * View sohifasini yaratib berish uchun
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function view(Request $request)
    {
        $user = Auth::user();
        $banners = Banners::getBanners(['blog_view']);
        $blog = BlogPosts::where(['slug' => $request->slug])->with(['categories'])->first();
        if ($blog == null) {
            return abort(404);
        }

        $likePosts = BlogPosts::getLikePosts($blog);
        $category = $blog->categories->getCategory();
        $blog->view_count++;
        $blog->save();
        $msgList = Chats::getMessages(3, $blog->id);
        $blogs = $blog->getPost();
        $langs = Additional::getLangs();
        $tags = BlogPostTags::where(['blog_posts_id' => $blog->id])->get();
        $seo = Seo::getMetaBlogView(
            Seo::getSeoKey('blogs', app()->getLocale()),
            $blogs,
            app()->getLocale(),
            $tags
        );

        return view(
            'blogs.view',
            [
                'blog' => $blogs,
                'category' => $category,
                'likePosts' => $likePosts,
                'banners' => $banners,
                'user' => $user,
                'langs' => $langs,
                'msgList' => $msgList,
                'seo' => $seo
            ]
        );
    }

    /**
     * Foydalanuvvchilar tomonidan yozilgan bloglarga like va dislikelar joylashtirib borish
     * Likeni yana qayta bosadigan bo'lsa like olinishi kerak
     *
     * @param Request $request
     * @return mixed
     */
    public function setLike(Request $request)
    {
        $user = Auth::user();
        if ($user != null) {
            $model = BlogsPostsLikes::where(['user_id' => $user->id, 'blog_posts_id' => $request->blog_id])->first();
            if ($model == null) {
                return BlogsPostsLikes::create(
                    [
                        'blog_posts_id' => $request->blog_id,
                        'type' => 1,
                        'user_id' => $user->id,
                    ]
                );
            } else {
                $model->delete();
            }
        }else{
            $like = Cookie::get("blog_likes_$request->blog_id");
            if($like == 1){
                Cookie::queue("blog_likes_$request->blog_id", 0, 1440);
            }else{
                Cookie::queue("blog_likes_$request->blog_id", 1, 1440);
            }
        }
    }

    /**
     * Blgolar uchun sharhlar qoldirish
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendComment(Request $request)
    {
        $user = Auth::user();
        if ($user != null) {
            $chat = Chats::where(['type' => 3, 'field_id' => $request->blog_id])->first();
            if ($chat == null) {
                Chats::createChat($request->blog_id, 3, $request->message);
            } else {
                ChatMessage::msgCreate($chat->id, $request->message, 'msg', $user->id);
            }
        }else{
            return redirect()->route('login-index');
        }

        return back()->with('success', trans('messages.Successfully saved'));
    }
}
