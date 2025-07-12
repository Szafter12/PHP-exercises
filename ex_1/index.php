<?php

require_once __DIR__ . '/Core/router.php';
require_once __DIR__ . '/Controllers/NoteController.php';

$router = new Router();

$router->get('/', [NoteController::class, 'index']);
$router->get('/note/{id}', [NoteController::class, 'show']);

$router->get('/note', [NoteController::class, 'add_note']);
$router->post('/note', [NoteController::class, 'store']);

$router->dispatch();


