<?php
require_once __DIR__ . '/../services/RequestService.php';

Flight::route('GET /requests', function () {
    respond(fn() => [200, (new RequestService())->getAll()]);
});

Flight::route('GET /requests/@id', function ($id) {
    respond(fn() => [200, (new RequestService())->getById((int) $id)]);
});

Flight::route('POST /requests', function () {
    respond(fn() => [201, (new RequestService())->create(body())]);
});

Flight::route('PUT /requests/@id', function ($id) {
    respond(fn() => [200, (new RequestService())->update((int) $id, body())]);
});

Flight::route('DELETE /requests/@id', function ($id) {
    respond(function () use ($id) {
        (new RequestService())->delete((int) $id);
        return [200, ['message' => 'Deleted']];
    });
});