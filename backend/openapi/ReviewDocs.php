<?php
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Review',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'user_id', type: 'integer', example: 2),
        new OA\Property(property: 'rating', type: 'integer', minimum: 1, maximum: 5, example: 5),
        new OA\Property(property: 'comment', type: 'string', nullable: true, example: 'Odličan rad i brza isporuka.'),
        new OA\Property(property: 'created_at', type: 'string', example: '2026-11-21 21:40:42'),
    ]
)]
#[OA\Schema(
    schema: 'ReviewInput',
    required: ['user_id', 'rating'],
    properties: [
        new OA\Property(property: 'user_id', type: 'integer', example: 2),
        new OA\Property(property: 'rating', type: 'integer', minimum: 1, maximum: 5, example: 5),
        new OA\Property(property: 'comment', type: 'string', nullable: true),
    ]
)]
class ReviewDocs
{
    #[OA\Get(
        path: '/reviews',
        tags: ['Reviews'],
        summary: 'List all reviews',
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of reviews',
                content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Review'))
            ),
        ]
    )]
    public function list() {}

    #[OA\Get(
        path: '/reviews/{id}',
        tags: ['Reviews'],
        summary: 'Get one review',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'The review', content: new OA\JsonContent(ref: '#/components/schemas/Review')),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function get() {}

    #[OA\Post(
        path: '/reviews',
        tags: ['Reviews'],
        summary: 'Create a review',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ReviewInput')),
        responses: [
            new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/Review')),
            new OA\Response(response: 400, description: 'Validation error (rating must be 1 to 5, user must exist)', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function create() {}

    #[OA\Put(
        path: '/reviews/{id}',
        tags: ['Reviews'],
        summary: 'Update a review',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ReviewInput')),
        responses: [
            new OA\Response(response: 200, description: 'Updated', content: new OA\JsonContent(ref: '#/components/schemas/Review')),
            new OA\Response(response: 400, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function update() {}

    #[OA\Delete(
        path: '/reviews/{id}',
        tags: ['Reviews'],
        summary: 'Delete a review',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Deleted'),
            new OA\Response(response: 404, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function delete() {}
}