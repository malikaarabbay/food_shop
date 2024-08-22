<?php

namespace App\Http\Controllers\Frontend;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    /**
     * Send message to chat via ajax
     *
     * @param Request $request
     * @return Response
     */
    function sendMessage(Request $request) : Response
    {
        $request->validate([
            'message' => ['required', 'max:1000'],
            'receiver_id' => ['required', 'integer'],
        ]);

        $senderId = auth()->user()->id;

        Chat::create(array_merge($request->all(), ['sender_id' => $senderId]));

        $avatar = asset(auth()->user()->image);

        broadcast(new ChatEvent($request->message, $avatar, $request->receiver_id, $senderId))->toOthers();

        return response(['status' => 'success', 'msgId' => $request->msg_temp_id]);
    }

    /**
     * Get cart products via ajax
     *
     * @param $senderId string
     * @return Response
     */
    function getConversation(string $senderId) : Response
    {
        $receiverId = auth()->user()->id;

        Chat::where('sender_id', $senderId)->where('receiver_id', $receiverId)->where('seen', 0)->update(['seen' => 1]);

        $messages = Chat::whereIn('sender_id', [$senderId, $receiverId])
            ->whereIn('receiver_id', [$senderId, $receiverId])
            ->with(['sender'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response($messages);
    }
}
