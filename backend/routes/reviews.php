<?php
require_once __DIR__ . '/../services/ReviewService.php';

Flight::route('GET /reviews', function () {
    respond(fn() => [200, (new ReviewService())->getAll()]);
});

Flight::route('GET /reviews/@id', function ($id) {
    respond(fn() => [200, (new ReviewService())->getById((int) $id)]);
});

Flight::route('POST /reviews', function () {
    respond(fn() => [201, (new ReviewService())->create(body())]);
});

Flight::route('PUT /reviews/@id', function ($id) {
    respond(fn() => [200, (new ReviewService())->update((int) $id, body())]);
});

Flight::route('DELETE /reviews/@id', function ($id) {
    respond(function () use ($id) {
        (new ReviewService())->delete((int) $id);
        return [200, ['message' => 'Deleted']];
    });
});