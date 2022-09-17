<?php 
$path =  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ;

$parts = explode('/',$path);

$resource = $parts[2];
$id = $parts[3] ?? null;

if($resource != 'tasks'){
    http_response_code(404);
    return;
}
echo $_SERVER['REQUEST_METHOD'];
