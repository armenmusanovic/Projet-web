<?php
require_once __DIR__ . '/../services/UserService.php';

Flight::route('GET /users', function () {
    respond(fn() => [200, (new UserService())->getAll()]);
});

Flight::route('GET /users/@id', function ($id) {
    respond(fn() => [200, (new UserService())->getById((int) $id)]);
});

Flight::route('POST /users', function () {
    respond(fn() => [201, (new UserService())->create(body())]);
});

Flight::route('PUT /users/@id', function ($id) {
    respond(fn() => [200, (new UserService())->update((int) $id, body())]);
});

Flight::route('DELETE /users/@id', function ($id) {
    respond(function () use ($id) {
        (new UserService())->delete((int) $id);
        return [200, ['message' => 'Deleted']];
    });
});