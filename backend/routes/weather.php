<?php
require_once __DIR__ . '/../services/WeatherService.php';

Flight::route('GET /weather', function () {
    try {
        Flight::json((new WeatherService())->getCurrentWeather());
    } catch (ExternalApiException $e) {
        // Vanjski servis ne radi: aplikacija i dalje radi, klijent dobija razumljivu poruku
        Flight::json(['error' => $e->getMessage()], 503);
    } catch (Throwable $e) {
        error_log($e->getMessage());
        Flight::json(['error' => 'Internal server error'], 500);
    }
});