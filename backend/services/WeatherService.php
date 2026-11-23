<?php
require_once __DIR__ . '/Exceptions.php';

class ExternalApiException extends Exception {}

class WeatherService
{
    private const TIMEOUT_SECONDS = 5;

    public function getCurrentWeather(): array
    {
        $config = require __DIR__ . '/../config/config.php';
        $key = $config['weather_api_key'] ?? '';
        $city = $config['weather_city'] ?? 'Kiseljak,BA';

        if ($key === '') {
            error_log('Weather API key is not configured');
            throw new ExternalApiException('Weather service is not configured');
        }

        $url = 'https://api.openweathermap.org/data/2.5/weather?' . http_build_query([
            'q' => $city,
            'appid' => $key,
            'units' => 'metric',
            'lang' => 'en',
        ]);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => self::TIMEOUT_SECONDS,
            CURLOPT_CONNECTTIMEOUT => self::TIMEOUT_SECONDS,
        ]);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            error_log('Weather API request failed: ' . $curlError);
            throw new ExternalApiException('Weather service is unavailable');
        }
        if ($status !== 200) {
            error_log('Weather API returned HTTP ' . $status);
            throw new ExternalApiException('Weather service is unavailable');
        }

        $data = json_decode($response, true);
        if (!is_array($data) || !isset($data['main']['temp'], $data['weather'][0])) {
            error_log('Weather API returned an unexpected response');
            throw new ExternalApiException('Weather service returned invalid data');
        }

        return [
            'city' => $data['name'] ?? $city,
            'temperature_c' => round($data['main']['temp'], 1),
            'feels_like_c' => round($data['main']['feels_like'] ?? $data['main']['temp'], 1),
            'humidity' => $data['main']['humidity'] ?? null,
            'description' => $data['weather'][0]['description'] ?? '',
            'wind_speed_ms' => $data['wind']['speed'] ?? null,
            'icon' => $data['weather'][0]['icon'] ?? null,
        ];
    }
}