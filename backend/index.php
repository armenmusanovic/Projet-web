<?php
require __DIR__ . '/vendor/autoload.php';

Flight::route('GET /ping', function () {
    Flight::json(['status' => 'ok']);
});

Flight::start();