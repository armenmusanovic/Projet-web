<?php
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'User',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Test Korisnik'),
        new OA\Property(property: 'email', type: 'string', format: 'email', example: 'user@klesarstvo.ba'),
        new OA\Property(property: 'role', type: 'string', enum: ['admin', 'user'], example: 'user'),
        new OA\Property(property: 'created_at', type: 'string', example: '2026-11-21 21:40:42'),
    ]
)]
#[OA\Schema(
    schema: 'UserInput',
    required: ['name', 'email', 'password'],
    properties: [
        new OA\Property(property: 'name', type: 'string', maxLength: 100, example: 'Novi Korisnik'),
        new OA\Property(property: 'email', type: 'string', format: 'email', example: 'novi@test.ba'),
        new OA\Property(property: 'password', type: 'string', minLength: 6, example: 'lozinka123'),
        new OA\Property(property: 'role', type: 'string', enum: ['admin', 'user']),
    ]
)]
class UserDocs
{
    #[OA\Get(
        path: '/users',
        tags: ['Users'],
        summary: 'List all users',
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of users (without password hash)',
                content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/User'))
            ),
        ]
    )]
    public function list() {}

    #[OA\Get(
        path: '/users/{id}',
        tags: ['Users'],
        summary: 'Get one user',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'The user', content: new OA\JsonContent(ref: '#/components/schemas/User')),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function get() {}

    #[OA\Post(
        path: '/users',
        tags: ['Users'],
        summary: 'Register a user',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/UserInput')),
        responses: [
            new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/User')),
            new OA\Response(response: 400, description: 'Validation error (invalid email, short password, email already in use)', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function create() {}

    #[OA\Put(
        path: '/users/{id}',
        tags: ['Users'],
        summary: 'Update a user',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/UserInput')),
        responses: [
            new OA\Response(response: 200, description: 'Updated', content: new OA\JsonContent(ref: '#/components/schemas/User')),
            new OA\Response(response: 400, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function update() {}

    #[OA\Delete(
        path: '/users/{id}',
        tags: ['Users'],
        summary: 'Delete a user',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Deleted'),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function delete() {}
}