<?php

namespace App\Http\Resources;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @mixin Message
 */
#[OA\Schema(
    title: 'MessageResource',
    description: 'Message resource',
    properties: [
        new OA\Property(property: 'id', type: 'integer', readOnly: true, example: 1),
        new OA\Property(property: 'content', type: 'string', example: 'John', nullable: true),
    ],
    additionalProperties: false,
)]
#[OA\Response(
	response: 'UserResource',
	description: 'Success',
	content: [new OA\JsonContent(properties:[new OA\Property(property: 'data', ref: '#/components/schemas/UserResource', type: 'object')])]
)]

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'id'         => $this->id,
            'content'    => $this->content,
            'created_at' => $this->created_at,
            'user'       => new UserResource($this->whenLoaded('user')),
        ];
    }
}
