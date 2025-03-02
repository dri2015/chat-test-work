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
