<?php
require_once __DIR__ . '/../services/WorkService.php';

Flight::route('GET /works', function () {
    respond(fn() => [200, (new WorkService())->getAll()]);
});

Flight::route('GET /works/@id', function ($id) {
    respond(fn() => [200, (new WorkService())->getById((int) $id)]);
});

Flight::route('POST /works', function () {
    respond(fn() => [201, (new WorkService())->create(body())]);
});

Flight::route('PUT /works/@id', function ($id) {
    respond(fn() => [200, (new WorkService())->update((int) $id, body())]);
});

Flight::route('DELETE /works/@id', function ($id) {
    respond(function () use ($id) {
        (new WorkService())->delete((int) $id);
        return [200, ['message' => 'Deleted']];
    });
});