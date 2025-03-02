<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * @property-read string $username
 */
#[OA\RequestBody(
    request: 'UserRequest',
    description: 'User request',
    required: true,
    content: [
        new OA\JsonContent(
            required: ['username'],
            properties: [
                new OA\Property(property: 'username', description: 'Username', type: 'string', example: 'user123'),
            ]
        )
    ]
)]
class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:40',
        ];
    }
}
