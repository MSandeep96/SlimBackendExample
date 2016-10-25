<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require_once '../include/DbHandler.php';

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);

$app = new \Slim\App($c);

$app->get('/', function ($request, $response, $args) {
    $response->write('Welcome to Trials!');
    return $response;
});


$app->get('/get_tasks',function ($request, $response, $args){
    $db=new DbHandler();
    $tasks=$db->getTasks();
    $response->write('{"resp":'.json_encode($tasks).'}');
    return $response;
});

$app->get('/get_tasks_paginated',function($request,$response,$args){
    $queries=$request->getQueryParams();
    $db=new DbHandler();
    $result=$db->getTasksPag($queries['page_no']);
    if(array_key_exists("out_of_limit_error",$result)){
        $response->write(json_encode($result));
    }else{
        $response->write('{"resp":'.json_encode($result).'}');
    }
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
