<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * @property-read string $content
 */
#[OA\RequestBody(
    request: 'MessageRequest',
    description: 'Message request',
    required: true,
    content: [
        new OA\JsonContent(
            required: ['content'],
            properties: [
                new OA\Property(property: 'content', description: 'Content', type: 'string', example: 'test message'),
            ]
        )
    ]
)]
class MessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => 'required|string|max:5000',
        ];
    }
}
