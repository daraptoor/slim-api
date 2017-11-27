<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';
require 'config/db.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "";
$config['db']['dbname'] = "test";



//$app = new Slim\App();
$app = new Slim\App(["settings" => $config]);

$app->get('/', function ($request, $response, $args) {
    return $response->write("Hello, Welcome to Slim Work.." );
});


$app->get('/{name}', function ($request, $response, $args) {
    return $response->write("Hello, " . $args['name']);
});

$app->post('/', function ($request, $response) {
	$data = $request->getParsedBody();
    return $response->write("Hello, " . filter_var($data['name'], FILTER_SANITIZE_STRING));
});

$app->post('/add', function(Request $request, Response $response){
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $sql = "INSERT INTO customers (first_name,last_name) VALUES
    (:first_name,:last_name)";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name',  $last_name);
        $stmt->execute();
        echo '{"notice": {"text": "Customer Added"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


$app->run();

// run local server php -S localhost:8000
// Referance https://github.com/bradtraversy/slimapp
// updated