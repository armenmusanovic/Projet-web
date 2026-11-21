<?php
require_once __DIR__ . '/../services/RequestItemService.php';

Flight::route('GET /request-items', function () {
    respond(fn() => [200, (new RequestItemService())->getAll()]);
});

Flight::route('GET /request-items/@id', function ($id) {
    respond(fn() => [200, (new RequestItemService())->getById((int) $id)]);
});

Flight::route('POST /request-items', function () {
    respond(fn() => [201, (new RequestItemService())->create(body())]);
});

Flight::route('PUT /request-items/@id', function ($id) {
    respond(fn() => [200, (new RequestItemService())->update((int) $id, body())]);
});

Flight::route('DELETE /request-items/@id', function ($id) {
    respond(function () use ($id) {
        (new RequestItemService())->delete((int) $id);
        return [200, ['message' => 'Deleted']];
    });
});