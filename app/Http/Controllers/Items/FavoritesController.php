<?php

namespace App\Http\Controllers\Items;

use Auth;
use Session;
use App\Models\Items\Favorites;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class FavoritesController extends Controller
{
    /**
     * Sevimlilar ro'yxatini qaytaradiga funksiya
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request)
    {
        $favorites = Favorites::getSearchedText();
        return view('favorites.list', ['favorites' => $favorites]);
    }

    /**
     * Sevimlimlar qatoridan chiqarish uchun
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $type = $request->type;
        $id = $request->id;

        if ($type == 'auth') {
            $fav = Favorites::where(['id' => $id])->first();
            if ($fav != null) {
                $fav->delete();
            }
        } else {
            $userSavedText = json_decode(Cookie::get('userSavedText'), true);
            $result = [];
            if (is_array($userSavedText)) {
                foreach ($userSavedText as $value) {
                    if ($value['time'] != $id) {
                        $result [] = [
                            'time' => $value['time'],
                            'search_text' => $value['search_text']
                        ];
                    }
                }
            }
            Cookie::queue('userSavedText', json_encode($result), 43200);
        }

        return redirect()->back()->with('success-deleted-message', trans('messages.Successful deleted'));
    }

    /**
     * Sevimlilarga qo'shish funksiyasi
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $model = Favorites::where(['user_id' => $user->id, 'type' => 4, 'search_text' => $request->text])->first();
            if ($model == null) {
                $model = new Favorites();
                $model->user_id = $user->id;
                $model->type = 4;
                $model->search_text = $request->text;
                $model->changed_date = date('Y-m-d H:i:s');
                $model->save();
            }
        } else {
            if (Cookie::get('userSavedText') == null) {
                $result = [];
                $result [] = [
                    'time' => time(),
                    'search_text' => $request->text
                ];
                Cookie::queue('userSavedText', json_encode($result), 43200);
            } else {
                $userSavedText = json_decode(Cookie::get('userSavedText'), true);
                $result = [];
                $flag = false;
                if (is_array($userSavedText)) {
                    foreach ($userSavedText as $value) {
                        if ($value['search_text'] == $request->text) {
                            $flag = true;
                        }
                        $result [] = [
                            'time' => $value['time'],
                            'search_text' => $value['search_text']
                        ];
                    }
                }
                if (!$flag) {
                    $result [] = [
                        'time' => time(),
                        'search_text' => $request->text
                    ];
                }
                Cookie::queue('userSavedText', json_encode($result), 43200);
            }
        }

        return redirect()->back()->with('success-saved', trans('messages.Successfully saved'));
    }

}