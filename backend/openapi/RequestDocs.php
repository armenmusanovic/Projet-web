<?php
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Request',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'user_id', type: 'integer', nullable: true, example: 2),
        new OA\Property(property: 'full_name', type: 'string', example: 'Test Korisnik'),
        new OA\Property(property: 'phone', type: 'string', example: '061111222'),
        new OA\Property(property: 'status', type: 'string', enum: ['pending', 'approved', 'rejected', 'completed'], example: 'pending'),
        new OA\Property(property: 'created_at', type: 'string', example: '2026-11-21 22:26:44'),
    ]
)]
#[OA\Schema(
    schema: 'RequestInput',
    required: ['full_name', 'phone'],
    properties: [
        new OA\Property(property: 'user_id', type: 'integer', nullable: true, example: 2),
        new OA\Property(property: 'full_name', type: 'string', maxLength: 100, example: 'Test Korisnik'),
        new OA\Property(property: 'phone', type: 'string', example: '061111222'),
    ]
)]
#[OA\Schema(
    schema: 'RequestUpdate',
    properties: [
        new OA\Property(property: 'user_id', type: 'integer', nullable: true),
        new OA\Property(property: 'full_name', type: 'string', maxLength: 100),
        new OA\Property(property: 'phone', type: 'string'),
        new OA\Property(property: 'status', type: 'string', enum: ['pending', 'approved', 'rejected', 'completed']),
    ]
)]
class RequestDocs
{
    #[OA\Get(
        path: '/requests',
        tags: ['Requests'],
        summary: 'List all requests',
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of requests',
                content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Request'))
            ),
        ]
    )]
    public function list() {}

    #[OA\Get(
        path: '/requests/{id}',
        tags: ['Requests'],
        summary: 'Get one request',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'The request', content: new OA\JsonContent(ref: '#/components/schemas/Request')),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function get() {}

    #[OA\Post(
        path: '/requests',
        tags: ['Requests'],
        summary: 'Create a request (status is always pending)',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/RequestInput')),
        responses: [
            new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/Request')),
            new OA\Response(response: 400, description: 'Validation error (invalid phone, user does not exist)', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function create() {}

    #[OA\Put(
        path: '/requests/{id}',
        tags: ['Requests'],
        summary: 'Update a request (for example change its status)',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/RequestUpdate')),
        responses: [
            new OA\Response(response: 200, description: 'Updated', content: new OA\JsonContent(ref: '#/components/schemas/Request')),
            new OA\Response(response: 400, description: 'Validation error (invalid status)', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function update() {}

    #[OA\Delete(
        path: '/requests/{id}',
        tags: ['Requests'],
        summary: 'Delete a request (its items are deleted too)',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Deleted'),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function delete() {}
}