<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
	title: 'ErrorResource',
	properties: [
		new OA\Property(property: 'success', type: 'boolean', example: false),
		new OA\Property(property: 'message', type: 'string', example: 'Error message'),
		new OA\Property(property: 'data', type: 'object'),
	],
	type: 'object',
)]
#[OA\Response(
	response: 'ErrorResource',
	description: 'Error',
	content: [new OA\JsonContent(ref: '#/components/schemas/ErrorResource')]
)]

class ErrorResource extends JsonResource
{
    protected int $statusCode = 400;

    protected string $message;

    public function __construct($message = 'Error', $data = [], $statusCode = 404)
    {
        parent::__construct($data);
        $this->statusCode = $statusCode;
        $this->message = $message;
    }

    public function toArray($request): array
    {
        return [
            'success' => false,
            'message' => $this->message,
            'data' => $this->resource,
        ];
    }

    public function withResponse($request, $response): void
    {
        $response->setStatusCode($this->statusCode);
    }
}
