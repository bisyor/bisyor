<?php

namespace App\Http\Controllers\References;

use App\Http\Controllers\Controller;
use App\Models\References\Contacts;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Telefon raqamni ko'rishni bosganda saytimiz rivoji uchun o'z takliflarini jo'natish imkoniyatixam bor.
     * O'sha yerdan kelgan post ma'lumotlarni bazaga yozadi
     *
     * @param Request $request
     * @throws mixed
     */
    public function storeFeedback(Request $request){

        $request->validate(['message' => 'required|string']);
        Contacts::create(
            [
                'message' => $request->message,
                'user_id' => auth()->id(),
                'user_ip' => $request->ip(),
                'useragent' => $request->userAgent(),
                'email' => auth()->user()->email ?? '',
                'name' => auth()->user()->fio ?? '',
                'type' => Contacts::CONTACT_TYPE_OFFER,
            ]);

        return 1;
    }
}
