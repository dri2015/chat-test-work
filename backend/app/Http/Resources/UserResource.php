<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @mixin User
 */
#[OA\Schema(
    title: 'UserResource',
    description: 'User resource',
    properties: [
        new OA\Property(property: 'id', type: 'integer', readOnly: true, example: 1),
        new OA\Property(property: 'username', type: 'string', example: 'john_doe', nullable: false),
        new OA\Property(property: 'color', type: 'string', example: '#ffffff', nullable: false),
    ],
    additionalProperties: false,
)]
#[OA\Response(
	response: 'UserResource',
	description: 'Success',
	content: [new OA\JsonContent(properties:[new OA\Property(property: 'data', ref: '#/components/schemas/UserResource', type: 'object')])]
)]

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'id'         => $this->id,
            'username'   => $this->username,
            'color'      => $this->color,
        ];
    }
}
