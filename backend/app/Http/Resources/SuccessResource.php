<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'SuccessResource',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'message', type: 'string', example: 'Success message'),
        new OA\Property(property: 'data', type: 'object'),
    ],
    type: 'object',
)]
#[OA\Response(
    response: 'SuccessResource',
    description: 'Success',
    content: [new OA\JsonContent(ref: '#/components/schemas/SuccessResource')]
)]
class SuccessResource extends JsonResource
{
    protected int $statusCode = 400;

    protected string $message;

    public function __construct($message = 'Success', $statusCode = 200, $data = [])
    {
        parent::__construct($data);
        $this->statusCode = $statusCode;
        $this->message = $message;
    }

    public function toArray($request): array
    {
        return [
            'success' => true,
            'message' => $this->message,
            'data' => $this->resource,
        ];
    }

    public function withResponse($request, $response): void
    {
        $response->setStatusCode($this->statusCode);
    }
}
