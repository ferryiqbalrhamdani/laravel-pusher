<?php

namespace App\Http\Controllers\API;

use App\Events\MessageCreated;
use App\Models\Conversation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function show($user_two)
    {
        $user_one = auth()->user()->id;

        $conversation = Conversation::where(function ($query) use ($user_one, $user_two){
            $query->where(['user_one' => $user_one, 'user_two' => $user_two]);
        })->orWhere(function ($query) use ($user_one, $user_two){
            $query->where(['user_one' => $user_two, 'user_two' => $user_one]);
        })->with('messages')->first();

        return response()->json([
            'data' => $conversation
        ]);
    }

    public function store(Request $request, Conversation $conversation)
    {
         $message = $conversation->messages()->create([
             'conversation_id' => $conversation->id,
             'body' => $request->body,
             'user_id' => auth()->user()->id,
         ]);

         MessageCreated::dispatch($message);

         return response()->json([
             'data' => $message,
             'status' => 'Success'
         ]);
    }
}
