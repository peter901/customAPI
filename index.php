<?php 
declare(strict_types=1);
ini_set('display_errors', 'On');

require_once(__DIR__.'/vendor/autoload.php');

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$path =  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ;

$parts = explode('/',$path);

$resource = $parts[2];
$id = $parts[3] ?? null;

if($resource != 'tasks'){
    http_response_code(404);
    exit;
}

header("Content-type: application/json; charset=UTF-8");

$database = new Database($_ENV['DB_HOST'],$_ENV['DB_NAME'],$_ENV['DB_USER'],$_ENV['DB_PASS']);

$taskGateway = new TaskGateway($database);

$controller = new TaskController($taskGateway);

$controller->processRequest($_SERVER['REQUEST_METHOD'],$id);
