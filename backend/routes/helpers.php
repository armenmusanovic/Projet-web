<?php
require_once __DIR__ . '/../services/Exceptions.php';

// Izvršava akciju i pretvara izuzetke u JSON sa ispravnim status kodom
function respond(callable $action): void
{
    try {
        [$status, $data] = $action();
        Flight::json($data, $status);
    } catch (ValidationException $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    } catch (NotFoundException $e) {
        Flight::json(['error' => $e->getMessage()], 404);
    } catch (Throwable $e) {
        error_log($e->getMessage());
        Flight::json(['error' => 'Internal server error'], 500);
    }
}

// Čita JSON tijelo zahtjeva
function body(): array
{
    $data = json_decode(file_get_contents('php://input'), true);
    return is_array($data) ? $data : [];
}