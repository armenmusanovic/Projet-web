<?php
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'RequestItem',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'request_id', type: 'integer', example: 1),
        new OA\Property(property: 'stone_type_id', type: 'integer', example: 1),
        new OA\Property(property: 'product', type: 'string', enum: ['Stepenice', 'Klupica', 'Nišan', 'Spomenik', 'Kamin', 'Ostalo'], example: 'Stepenice'),
        new OA\Property(property: 'length_cm', type: 'integer', minimum: 1, example: 120),
        new OA\Property(property: 'width_cm', type: 'integer', minimum: 1, example: 30),
        new OA\Property(property: 'height_cm', type: 'integer', minimum: 1, example: 15),
        new OA\Property(property: 'engraving_text', type: 'string', nullable: true, example: 'Ime i prezime'),
    ]
)]
#[OA\Schema(
    schema: 'RequestItemInput',
    required: ['request_id', 'stone_type_id', 'product', 'length_cm', 'width_cm', 'height_cm'],
    properties: [
        new OA\Property(property: 'request_id', type: 'integer', example: 1),
        new OA\Property(property: 'stone_type_id', type: 'integer', example: 1),
        new OA\Property(property: 'product', type: 'string', enum: ['Stepenice', 'Klupica', 'Nišan', 'Spomenik', 'Kamin', 'Ostalo'], example: 'Stepenice'),
        new OA\Property(property: 'length_cm', type: 'integer', minimum: 1, example: 120),
        new OA\Property(property: 'width_cm', type: 'integer', minimum: 1, example: 30),
        new OA\Property(property: 'height_cm', type: 'integer', minimum: 1, example: 15),
        new OA\Property(property: 'engraving_text', type: 'string', nullable: true),
    ]
)]
class RequestItemDocs
{
    #[OA\Get(
        path: '/request-items',
        tags: ['Request items'],
        summary: 'List all request items',
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of request items',
                content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/RequestItem'))
            ),
        ]
    )]
    public function list() {}

    #[OA\Get(
        path: '/request-items/{id}',
        tags: ['Request items'],
        summary: 'Get one request item',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'The request item', content: new OA\JsonContent(ref: '#/components/schemas/RequestItem')),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function get() {}

    #[OA\Post(
        path: '/request-items',
        tags: ['Request items'],
        summary: 'Create a request item',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/RequestItemInput')),
        responses: [
            new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/RequestItem')),
            new OA\Response(response: 400, description: 'Validation error (unknown product, dimension below 1, request or stone type does not exist)', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function create() {}

    #[OA\Put(
        path: '/request-items/{id}',
        tags: ['Request items'],
        summary: 'Update a request item',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/RequestItemInput')),
        responses: [
            new OA\Response(response: 200, description: 'Updated', content: new OA\JsonContent(ref: '#/components/schemas/RequestItem')),
            new OA\Response(response: 400, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function update() {}

    #[OA\Delete(
        path: '/request-items/{id}',
        tags: ['Request items'],
        summary: 'Delete a request item',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Deleted'),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function delete() {}
}