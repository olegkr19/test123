<?php

use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\App;

return function (App $app) {
    $app->get('/api/ru/clients', \App\Controllers\ClientsController::class . ':index');
    $app->get('/api/ru/client/{id}', \App\Controllers\ClientsController::class . ':show');
    $app->post('/api/ru/client', \App\Controllers\ClientsController::class . ':store');
    $app->put('/api/ru/client/{id}', \App\Controllers\ClientsController::class . ':update');
    $app->delete('/api/ru/client/{id}', \App\Controllers\ClientsController::class . ':delete');
};
