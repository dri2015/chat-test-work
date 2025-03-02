<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/user",
     *     summary="Create or retrieve a user",
     *     description="Finds an existing user by username or creates a new one with a random color.",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username"},
     *             @OA\Property(property="username", type="string", example="john_doe")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User retrieved or created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/UserResource")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="ERROR_MAKE_USER")
     *         )
     *     )
     * )
     */
    public function user(UserRequest $request): JsonResource
    {
        try {
            $user = User::firstOrCreate(
                ['username' => $request->username],
                ['color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF))]
            );
            return new UserResource($user);
        } catch (Exception $e) {
            return new ErrorResource(message: 'ERROR_MAKE_USER', statusCode: 500);
        }
    }
}
