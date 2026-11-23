<?php
require_once __DIR__ . '/../services/StoneTypeService.php';

Flight::route('GET /stone-types', function () {
    respond(fn() => [200, (new StoneTypeService())->getAll()]);
});

Flight::route('GET /stone-types/@id', function ($id) {
    respond(fn() => [200, (new StoneTypeService())->getById((int) $id)]);
});

Flight::route('POST /stone-types', function () {
    respond(fn() => [201, (new StoneTypeService())->create(body())]);
});

Flight::route('PUT /stone-types/@id', function ($id) {
    respond(fn() => [200, (new StoneTypeService())->update((int) $id, body())]);
});

Flight::route('DELETE /stone-types/@id', function ($id) {
    respond(function () use ($id) {
        (new StoneTypeService())->delete((int) $id);
        return [200, ['message' => 'Deleted']];
    });
});