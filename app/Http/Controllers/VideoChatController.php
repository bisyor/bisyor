<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\StartVideoChat;

class VideoChatController extends Controller
{

    public function callUser(Request $request)
    {
        $data['userToCall'] = $request->user_to_call;
        $data['signalData'] = $request->signal_data;
        $data['from'] = Auth::id();
        $data['type'] = 'incomingCall';
        $data['item_owner'] = $request->item_owner;;
        broadcast(new StartVideoChat($data))->toOthers();
    }


    public function acceptCall(Request $request)
    {

        $data['signal'] = $request->signal;
        $data['to'] = $request->to;
        $data['type'] = 'callAccepted';
        $data['item_owner'] = $request->item_owner;;
        broadcast(new StartVideoChat($data))->toOthers();
    }
    
    public function declineCall(Request $request){
        
        $data['signal'] = $request->signal;
        $data['user'] = $request->user;
        $data['type'] = 'declineCall';
        $data['item_owner'] = $request->item_owner;;
        broadcast(new StartVideoChat($data))->toOthers();
    }
}
