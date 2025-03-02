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
    /**
     * @OA\Get(
     *     path="/messages",
     *     summary="Get a list of messages",
     *     description="Returns a list of messages with users, sorted by creation date.",
     *     tags={"Messages"},
     *     @OA\Response(
     *         response=200,
     *         description="List of messages",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/MessageResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="ERROR_GET_MESSAGES")
     *         )
     *     )
     * )
     */
    public function index(): JsonResource
    {
        try {
            $messages = Message::with('user')->orderBy('created_at')->get();

            return MessageResource::collection($messages);

        } catch (Exception $e) {
            return new ErrorResource(message: 'ERROR_GET_MESSAGES', statusCode: 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/messages",
     *     summary="Create a new message",
     *     description="Stores a new message and returns the created message with user details.",
     *     tags={"Messages"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"content"},
     *             @OA\Property(property="content", type="string", example="Hello, world!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Message created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/MessageResource")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="ERROR_CREATE_MESSAGE")
     *         )
     *     )
     * )
     */
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
