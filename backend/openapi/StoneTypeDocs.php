<?php
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Error',
    properties: [new OA\Property(property: 'error', type: 'string', example: 'Record not found')]
)]
#[OA\Schema(
    schema: 'StoneType',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Granit'),
        new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Vrlo čvrst, dugotrajan.'),
        new OA\Property(property: 'image', type: 'string', nullable: true, example: 'stepenice-granit.jpg'),
    ]
)]
#[OA\Schema(
    schema: 'StoneTypeInput',
    required: ['name'],
    properties: [
        new OA\Property(property: 'name', type: 'string', maxLength: 100, example: 'Granit'),
        new OA\Property(property: 'description', type: 'string', nullable: true),
        new OA\Property(property: 'image', type: 'string', nullable: true),
    ]
)]
class StoneTypeDocs
{
    #[OA\Get(
        path: '/stone-types',
        tags: ['Stone types'],
        summary: 'List all stone types',
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of stone types',
                content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/StoneType'))
            ),
        ]
    )]
    public function list() {}

    #[OA\Get(
        path: '/stone-types/{id}',
        tags: ['Stone types'],
        summary: 'Get one stone type',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'The stone type', content: new OA\JsonContent(ref: '#/components/schemas/StoneType')),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function get() {}

    #[OA\Post(
        path: '/stone-types',
        tags: ['Stone types'],
        summary: 'Create a stone type',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/StoneTypeInput')),
        responses: [
            new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/StoneType')),
            new OA\Response(response: 400, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function create() {}

    #[OA\Put(
        path: '/stone-types/{id}',
        tags: ['Stone types'],
        summary: 'Update a stone type',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/StoneTypeInput')),
        responses: [
            new OA\Response(response: 200, description: 'Updated', content: new OA\JsonContent(ref: '#/components/schemas/StoneType')),
            new OA\Response(response: 400, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function update() {}

    #[OA\Delete(
        path: '/stone-types/{id}',
        tags: ['Stone types'],
        summary: 'Delete a stone type',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Deleted'),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function delete() {}
}