<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

class MessagesController extends Controller
{
    public function index(): JsonResource
    {
        try {
            $messages = Message::with('user')->orderBy('created_at')->get();

            return MessageResource::collection($messages);

        } catch (Exception $e) {
            return new ErrorResource(message: 'ERROR_GET_MESSAGES', statusCode: 500);
        }
    }

    public function store(MessageRequest $request): JsonResource|ErrorResource
    {
        try {
            $user = $request->attributes->get('user');

            $message = Message::create([
                'user_id' => $user->id,
                'content' => $request->content,
            ]);

            return new MessageResource($message->load('user'));
        } catch (Exception $e) {
            return new ErrorResource(message: 'ERROR_CREATE_MESSAGE', statusCode: 500);
        }
    }
}
