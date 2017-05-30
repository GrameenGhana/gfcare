<?php

namespace App\Gfcare\src\MobileMidwife\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\GfCare\src\MobileMidwife\Models\Message;


class MessageController extends Controller
{
    public function show(Request $request, $teamId=null)
    {
        $i = Message::all();
        return response()->json($i);
    }
    
    public function storeSMS(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
                                'content' => 'required',
                                'to' => 'required',
                        ]);

        $msg = new Message();
        $msg->to = $request->to;
        $msg->channel = 'sms';
        $msg->content = $request->content;
        $msg->modified_by = $user->id;
        $msg->save();
            
        return response()->json($msg); 
    }
    
    public function storeVoice(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
                                'content' => 'required',
                                'to' => 'required',
                        ]);

        $msg = new Message();
        $msg->to = $request->to;
        $msg->channel = 'voice';
        $msg->content = $request->content;
        $msg->modified_by = $user->id;
        $msg->save();
            
        return response()->json($msg); 
    }
}
