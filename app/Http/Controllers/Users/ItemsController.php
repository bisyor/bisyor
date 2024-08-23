<?php

namespace App\Http\Controllers\Users;

use App\Models\Chats\ChatMessage;
use App\Models\Chats\Chats;
use App\Models\Chats\ChatUsers;
use App\Models\Items\ItemsViews;
use App\Models\References\Additional;
use App\Models\References\Caching;
use App\Models\References\UserSubscribers;
use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Items\Favorites;
use App\Models\Items\Items;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

/**
 * Foydalanuvchining shaxsiy elonlari bilan ishlash cantrolleri
 * Class ItemsController
 * @package App\Http\Controllers\Users
 */
class ItemsController extends Controller
{
    /**
     * Foydalanuvchining faqat o'ziga tegishli elonlarini qaytarish
     * Barcha statuslarni sahifa bo'yicha olish
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function itemsList(Request $request)
    {
        $user = Auth::user();
        $page = $request->page ?: 1;
        $active_tab = $request->a_t ?: '#ff1';
        $allItems = Items::getUserItems($user->id, $active_tab == '#ff5' ? $page : 1, $request);
        $activeItems = Items::getUserActiveItems($user->id, $active_tab == '#ff1' ? $page : 1, $request);
        $moderatingItems = Items::getUserModeratingItems($user->id, $active_tab == '#ff2' ? $page : 1, $request);
        $noActiveItems = Items::getUserNoActiveItems($user->id, $active_tab == '#ff3' ? $page : 1, $request);
        $blockedItems = Items::getUserBlockedItems($user->id, $active_tab == '#ff4' ? $page :1, $request);
        $category_list = Additional::getTopCategories();
        return view(
            'users.items.list',
            [
                'user' => $user,
                'allItems' => $allItems,
                'activeItems' => $activeItems,
                'moderatingItems' => $moderatingItems,
                'noActiveItems' => $noActiveItems,
                'blockedItems' => $blockedItems,
                'category_list' => $category_list,
                'active_tab' => $active_tab,
                'page' => $page+1
            ]
        );
    }

    /**
     * Profildagi elonlarni paginatsiya bilanchiqarish uchun funksiya
     * Ikki hol uchun ishlaydi
     * Birinchi barcha elonlar menusi uchun
     * Ikkinchi aktiv elonlar uchun ishlaydi.
     * itemschild fayliga massivni yuboradi va u yerdan html shablonni qabul qilib oladi.
     * Htm shablonni esa massiv ko'rinishida jontatib yuboradi
     *
     * @param Request $request
     * @return array
     * @throws \Throwable
     */
    public function itemListPage(Request $request)
    {
        $user = Auth::user();
        $page = $request->page;
        $type = $request->type;

        if ($type == 'ff0') {
            $items = Items::getUserItems($user->id, $page, $request);
        } elseif ($type == 'ff1') {
            $items = Items::getUserActiveItems($user->id, $page, $request);
        } elseif ($type == 'ff2') {
            $items = Items::getUserModeratingItems($user->id, $page, $request);
        } elseif ($type == 'ff3') {
            $items = Items::getUserNoActiveItems($user->id, $page, $request);
        } else {
            $items = Items::getUserBlockedItems($user->id, $page, $request);
        }

        return [
            'status' => 'success',
            'itemCount' => count($items),
            'msg' => view('users.items.itemschild')->with(compact('items'))->render(),
        ];
    }

    /**
     * Elon statusini o'zgartirish
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function changeStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $is_publicated = $request->is_publicated;
        $is_moderating = $request->is_moderating;
        $is_buyed = $request->is_buyed;
        $item = Items::where(['id' => $id])->firstOrFail();
        $item->status_prev = $item->status;
        $item->status = $status;
        $item->is_publicated = $is_publicated;
        $item->is_moderating = $is_moderating;
        $item->is_buyed = $is_buyed;
        $item->save();

        return back();
    }

    /**
     * Foydalanuvchi sevimlilarga qoo'shgan elonlari sahifasi
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function favorites()
    {
        $user = Auth::user();
        $favorites = Favorites::getFavorites($user->id);
        $searchFavorites = Favorites::getSearchedText();
        $viewFavorites = Favorites::getViewFavorites($user->id);

        return view(
            'users.items.favorites',
            [
                'user' => $user,
                //'allFavorites' => $allFavorites,
                'favorites' => $favorites,
                'searchFavorites' => $searchFavorites,
                'viewFavorites' => $viewFavorites,
            ]
        );
    }

    /**
     * Elon muallifiga habar yuborish
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function message(Request $request)
    {
        $user = Auth::user();
        $receiver = $request->user_id;
        $item_id = $request->item_id;
        $validator = Validator::make($request->all(),
            [
                'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'message' => 'required',
                'user_id' => 'required|exists:users,id',
            ]);

        if ($request->ajax()) {
            if($validator->fails()) {
                return response()->json(['message' => $validator->errors()->getMessages()], 400);
            }
        } else {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        }

        $message = $request->message;
        $file = $request->file('file');

        $chat = ChatUsers::leftJoin('chats', 'chat_users.chat_id', '=', 'chats.id')
            ->where('chat_users.item_id', $item_id)
            ->where('chat_users.user_id', auth()->id())
            ->where('chats.type', Chats::CHAT_ITEMS)
            ->where('chats.field_id', $item_id)
            ->first();

        if($chat) {
            ChatUsers::createUser($receiver, $chat->id, $item_id);
            ChatUsers::createUser($user->id, $chat->id, $item_id);
            ChatMessage::msgCreate($chat->id, $message, 'msg', $user->id);
        } else {
            $chat = Chats::create([
                'name' => 'items_chats_' . $item_id . '_' . $user->id,
                'field_id' => $item_id, 'type' => Chats::CHAT_ITEMS,
                'status' => 1
            ]);
            ChatUsers::createUser($receiver, $chat->id, $item_id);
            ChatUsers::createUser($user->id, $chat->id, $item_id);
            ChatMessage::msgCreate($chat->id, $message, 'msg', $user->id);
        }
        if ($file && $chat) {
            $chatMessage = new ChatMessage();
            $chatMessage->user_id = $user->id;
            $chatMessage->chat_id = $chat->id;
            $chatMessage->date_cr = date('Y-m-d H:i:s');
            $chatMessage->is_read = 0;
            $chatMessage->setImage($file);
            $chatMessage->save();
        }
        if ($request->ajax()) {
            return ['message' => trans('messages.Message sent successfully')];
        }
        return redirect()->back()->withErrors(['success' => trans('messages.Message sent successfully')]);
    }

    /**
     * Elonni auto ko'tarishga qo'yishni sozlamasi
     * Tugallanmagan funksiya
     *
     * @param Request $request
     * @return array
     */
    public function itemAutoSetting(Request $request)
    {
        $item = Items::where('id', $request->item_id)->first();
        if ($item == null) return "auto-error";

        if (strlen(($item->svc_upauto_sett)) == 0) return 'auto-error';

        $setting = unserialize($item->svc_upauto_sett);
        if (isset($setting['p'])) {
            return [
                'p' => $setting['p'],
                't' => $setting['t'],
                'h' => $setting['h'],
                'm' => $setting['m'],
                'fr_h' => $setting['fr_h'],
                'fr_m' => $setting['fr_m'],
                'to_h' => $setting['to_h'],
                'to_m' => $setting['to_m'],
                'int' => $setting['int'],
            ];
        } else return 'auto-error';
    }

    /**
     * Elonni auto ko'tarishga qo'yish
     * Tugallanmagan funksiya
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function autoRaise(Request $request)
    {
        /*return $request->all();
        $serial = serialize($array);
        return $serial;*/
        $validator = $this->validatorRaise($request->all());
        if ($validator->fails()) {
            $request->session()->flash(
                'error-message',
                trans('messages.Model error text') . implode(', ', $validator->errors()->all())
            );
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        /*
         * Fields in $request
         * raise_auto : Input checkbox
         * p : Select first
         * t : Select second
         * h : Select hour
         * m : Select minute
         * if t === 1
         * fr_h : Select from hour
         * fr_m " Select from minute
         * fr_h : Select to hour
         * fr_m : Select to minute
         * int : Select type time hour
         * */

        $array = [
            'p' => $request->p,
            't' => $request->t,
            'h' => $request->h,
            'm' => $request->m,
            'fr_h' => $request->fr_h,
            'fr_m' => $request->fr_m,
            'to_h' => $request->to_h,
            'to_m' => $request->to_m,
            'int' => $request->int,
        ];

        if ($request->t == '1') {
            $hour = $request->h < 10 ? ('0' . $request->h) : $request->h;
            $minut = $request->m < 10 ? ('0' . $request->m) : $request->m;
            $svc_upauto_next = date('Y-m-d ' . $hour . ':' . $minut . ':00');
        } else {
            $fr_hour = $request->fr_h < 10 ? ('0' . $request->fr_h) : $request->fr_h;
            $fr_minut = $request->fr_m < 10 ? ('0' . $request->fr_m) : $request->fr_m;
            $svc_upauto_next = date('Y-m-d ' . $fr_hour . ':' . $fr_minut . ':00');
        }

        $model = Items::where(['id' => $request->id_item])->first();
        $model->svc_upauto_sett = serialize($array);
        $model->svc_upauto_next = $svc_upauto_next;
        if (isset($request->raise_auto)) $model->svc_upauto_on = 1;
        else $model->svc_upauto_on = 0;
        $model->save();

        $request->session()->flash('success-changed', trans('messages.Successfully saved'));
        return response()->json(['success' => true]);
    }

    /**
     * Avto ko'tarish formasini validatsiya qilish
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorRaise(array $data)
    {
        return Validator::make(
            $data,
            [
                'p' => 'required',
                't' => 'required',
                'h' => 'required',
                'm' => 'required',
            ]
        );
    }

    public function resetCount(Request $request)
    {
        $item_id = $request->id;
        $type = $request->type;


        $user = Auth::user();
        $model = Items::whereId($item_id)->whereUserId($user->id)->first();
        if (!$model) {
            abort(300);
        }
        if ($type == 'contact') {
            ItemsViews::clearContactCount($model->id);
        } elseif($type == 'message') {
            Chats::deleteItemMessage($model->id);
        }else {
            ItemsViews::clearViewCount($model->id);
        }

        return redirect()->back();
    }

    public function subscribeUser(Request $request)
    {
        $user_id = $request->id;
        $shop = User::where(['id' => $user_id])->first();
        if ($shop == null) abort(404);
        $subscriber = Auth::user();
        $subscribe = UserSubscribers::where(['from_user_id' => $subscriber->id, 'to_user_id' => $user_id])->first();
        if ($subscribe) {
            $subscribe->delete();
        } else {
            UserSubscribers::updateOrCreate(
                ['from_user_id' => $subscriber->id, 'to_user_id' => $user_id],
                [
                    'from_user_id' => $subscriber->id,
                    'to_user_id' => $user_id,
                ]
            );
        }
        return redirect()->back()->with('success-changed', trans('messages.Successfully saved'));
    }

    public function itemViewsStat(Items $item, int $back_days = 30)
    {
        $item_lists = ItemsViews::getStatByDate($item, $back_days);
        return response()->json([
            'labels' => array_column($item_lists, 'period'),
            'item_views' => array_column($item_lists, 'item_views'),
            'contacts_views' => array_column($item_lists,'contacts_views')
        ]);
    }

}
