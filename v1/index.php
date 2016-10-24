<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require_once '../include/DbHandler.php';

$app = new \Slim\App;

$app->get('/', function ($request, $response, $args) {
    $response->write('Welcome to Trials!');
    return $response;
});


$app->get('/get_tasks',function ($request, $response, $args){
    $db=new DbHandler();
    $tasks=$db->getTasks();
    $response->write(json_encode($tasks));
    return $response;
});

$app->post('/add_task',function ($request, $response, $args){
    $json_rec=$request->getParsedBody();
    $task_rec=$json_rec['task'];
    $db=new DbHandler();
    $resp=$db->createTask($task_rec);
    $response->write(json_encode($resp));
    return $response;
});

$app->run();


?>
