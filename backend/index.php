<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/routes/helpers.php';
require __DIR__ . '/routes/stone_types.php';
require __DIR__ . '/routes/works.php';

Flight::route('GET /ping', function () {
    Flight::json(['status' => 'ok']);
});

Flight::start();