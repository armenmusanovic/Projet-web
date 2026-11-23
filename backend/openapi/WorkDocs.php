<?php
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Work',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', example: 'Stepenice od granita'),
        new OA\Property(property: 'description', type: 'string', nullable: true),
        new OA\Property(property: 'image', type: 'string', nullable: true, example: 'stepenice-granit.jpg'),
        new OA\Property(property: 'stone_type_id', type: 'integer', example: 1),
    ]
)]
#[OA\Schema(
    schema: 'WorkInput',
    required: ['title', 'stone_type_id'],
    properties: [
        new OA\Property(property: 'title', type: 'string', maxLength: 150, example: 'Stepenice od granita'),
        new OA\Property(property: 'description', type: 'string', nullable: true),
        new OA\Property(property: 'image', type: 'string', nullable: true),
        new OA\Property(property: 'stone_type_id', type: 'integer', example: 1),
    ]
)]
class WorkDocs
{
    #[OA\Get(
        path: '/works',
        tags: ['Works'],
        summary: 'List all works',
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of works',
                content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Work'))
            ),
        ]
    )]
    public function list() {}

    #[OA\Get(
        path: '/works/{id}',
        tags: ['Works'],
        summary: 'Get one work',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'The work', content: new OA\JsonContent(ref: '#/components/schemas/Work')),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function get() {}

    #[OA\Post(
        path: '/works',
        tags: ['Works'],
        summary: 'Create a work',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/WorkInput')),
        responses: [
            new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/Work')),
            new OA\Response(response: 400, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function create() {}

    #[OA\Put(
        path: '/works/{id}',
        tags: ['Works'],
        summary: 'Update a work',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/WorkInput')),
        responses: [
            new OA\Response(response: 200, description: 'Updated', content: new OA\JsonContent(ref: '#/components/schemas/Work')),
            new OA\Response(response: 400, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function update() {}

    #[OA\Delete(
        path: '/works/{id}',
        tags: ['Works'],
        summary: 'Delete a work',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Deleted'),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function delete() {}
}