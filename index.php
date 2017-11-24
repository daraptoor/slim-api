<?php
require 'vendor/autoload.php';
$app = new Slim\App();

$app->get('/{name}', function ($request, $response, $args) {
    return $response->write("Hello, " . $args['name']);
});

$app->post('/', function ($request, $response) {
	$data = $request->getParsedBody();
    return $response->write("Hello, " . $data['name']);
});

$app->run();

// run local server php -S localhost:8000