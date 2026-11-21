<?php
// Učitaj sve fajlove sa opisima API-ja iz foldera openapi
foreach (glob(__DIR__ . '/../openapi/*.php') as $file) {
    require_once $file;
}

// Generiše OpenAPI dokumentaciju iz anotacija u kodu
Flight::route('GET /openapi.json', function () {
    try {
        $openapi = (new \OpenApi\Generator())->generate([
            __DIR__ . '/../openapi',
        ]);
        header('Content-Type: application/json');
        echo $openapi->toJson();
    } catch (Throwable $e) {
        Flight::json([
            'error' => $e->getMessage(),
            'file' => basename($e->getFile()),
            'line' => $e->getLine(),
        ], 500);
    }
});