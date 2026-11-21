<?php
use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Klesarstvo Musanovic API',
    version: '1.0.0',
    description: 'REST API for a stone-crafting workshop: stone types, works, users, requests, request items and reviews.'
)]
#[OA\Server(url: '/ArmenMusanovic/Projet-web/backend', description: 'Local server')]
class OpenApiInfo
{
}