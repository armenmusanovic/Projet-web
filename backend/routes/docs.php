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
        error_log($e->getMessage());
        Flight::json(['error' => 'Could not generate API documentation'], 500);
    }
});


// Stranica sa Swagger UI-jem
Flight::route('GET /docs', function () {
    header('Content-Type: text/html; charset=utf-8');
    echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Klesarstvo Musanovic API docs</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swagger-ui-dist@5/swagger-ui.css">
</head>
<body>
  <div id="swagger-ui"></div>
  <script src="https://cdn.jsdelivr.net/npm/swagger-ui-dist@5/swagger-ui-bundle.js"></script>
  <script>
    SwaggerUIBundle({ url: 'openapi.json', dom_id: '#swagger-ui' });
  </script>
</body>
</html>
HTML;
});