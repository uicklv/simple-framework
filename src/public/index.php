<?php

use App\system\Router;

require_once "../vendor/autoload.php";

$router = new Router();

$router->addRoute("/", ['get' => 'HomeController@index']);

$router->processRoute(\App\system\Request::getUrl(), \App\system\Request::getMethod());