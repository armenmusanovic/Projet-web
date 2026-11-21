<?php
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Weather',
    properties: [
        new OA\Property(property: 'city', type: 'string', example: 'Kiseljak'),
        new OA\Property(property: 'temperature_c', type: 'number', example: 4),
        new OA\Property(property: 'feels_like_c', type: 'number', example: 1.9),
        new OA\Property(property: 'humidity', type: 'integer', example: 97),
        new OA\Property(property: 'description', type: 'string', example: 'clear sky'),
        new OA\Property(property: 'wind_speed_ms', type: 'number', example: 2.28),
        new OA\Property(property: 'icon', type: 'string', example: '01n'),
    ]
)]
class WeatherDocs
{
    #[OA\Get(
        path: '/weather',
        tags: ['External API'],
        summary: 'Current weather for the workshop location (OpenWeatherMap)',
        description: 'Calls the external OpenWeatherMap API from the backend (the API key stays on the server). Used to help customers plan outdoor stonework installation.',
        responses: [
            new OA\Response(response: 200, description: 'Current weather', content: new OA\JsonContent(ref: '#/components/schemas/Weather')),
            new OA\Response(response: 503, description: 'External weather service is unavailable or not configured', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 500, description: 'Internal server error', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function weather() {}
}