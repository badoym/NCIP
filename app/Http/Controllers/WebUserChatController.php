<?php

namespace App\Http\Controllers;

use App\Models\message;
use Illuminate\Http\Request;

class WebUserChatController extends Controller
{
    public function index(){
        $user_id = Auth()->user()->id;
        return view('webusers.chat', compact('user_id'));
    }
    public function fetchMessage(){
        $messages = message::leftJoin('users','messages.user_id' ,'users.id')
        ->select('messages.*', 'users.name')
        ->get();
        return response()->json(['messages' => $messages], 200);
    }
    public function send(Request $request){

        $data = new message();
        $data->message = $request->message;
        $data->user_id = Auth()->user()->id;
        $data->save();

        return response()->json(['message' => 'sent'], 200);
    }
}
