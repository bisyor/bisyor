<?php

namespace App\Http\Controllers\Items;

use App\Http\Controllers\Controller;
use App\Models\Items\Applications;
use App\Models\Items\Items;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return
     */
    public function store(Request $request)
    {
        $token = config('app.botToken');
        $chatID = "-1001675149958";
        $validated_data = $request->validate([
            'item_id' => 'required',
            'phone' => 'required',
            'fullname' => 'required|string',
            'address' => 'required|string'
        ]);

        Applications::create($validated_data + ['status' => Applications::STATUS_NEW]);

        $item = Items::where('id' , $request->item_id)->select(['id','link','title'])->first();
        $link = "https://bisyor.uz/obyavlenie/".$item->link;
        $text ="[Товар: ".$item->title."](".$link.")";

        $text .= "\n\nФИО: ".$request->fullname;
        $text .= "\n\nТелефон: ".$request->phone;
        $text .= "\n\nДата создания: ".date('d.m.Y H:i', strtotime(date('Y-m-d H:i')));
        $text .= "\n\nАдрес: ".$request->address;

        $data = [
            'text' => $text,
            'chat_id' => $chatID,
            'parse_mode' => 'markdown',
            'disable_web_page_preview' => true,
        ];

        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?" .http_build_query($data);
        $this->file_get_contents_curl($url);
        return response()->json(true, 201);
    }

    /**
     * file get content sslni a
     */
    public function file_get_contents_curl($url){
        $arrContextOptions = stream_context_create([
            "ssl"=>[
                "verify_peer"   =>  false,
                "verify_peer_name"  =>  false,
            ],
        ]);
        return file_get_contents($url , false , $arrContextOptions);
    }

}
