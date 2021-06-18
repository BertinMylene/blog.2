<?php

use Core\Http\Request;

define('ROOT', dirname(__DIR__));

require ROOT . '/App/App.php';
require_once ROOT . '/vendor/autoload.php';

$request = new Request($_GET, $_POST, $_SESSION);

App::load();


if ($request->hasGetValue('p')) {
    $p = $request->getGetValue('p');
} else {
    $p = 'post.index';
}

$p = explode('.', $p);

if ($p[0] === 'admin') {
    $controler = '\App\Controller\Admin\\' . ucfirst($p[1]) . 'Controller';
    $action = $p[2];
} else {
    $controler = '\App\Controller\\' . ucfirst($p[0]) . 'Controller';
    $action = $p[1];
}

$controller = new $controler($request);
$controller->$action();