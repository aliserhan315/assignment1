<?php

$base_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($request, $base_dir) === 0) {
    $request = substr($request, strlen($base_dir));
}


if ($request == '') {
    $request = '/';
}

$apis = [
    '/articles' => [
        'GET'    => ['controller' => 'ArticleController', 'method' => 'getAllArticles'],
        'POST'   => ['controller' => 'ArticleController', 'method' => 'createArticle'],
        'PUT'    => ['controller' => 'ArticleController', 'method' => 'updateArticle'],
        'DELETE' => ['controller' => 'ArticleController', 'method' => 'deleteAllArticles'],
    ],


    '/login'         => ['controller' => 'AuthController', 'method' => 'login'],
    '/register'         => ['controller' => 'AuthController', 'method' => 'register'],
    '/Categories' => [
    'GET'    => ['controller' => 'CategoryController', 'method' => 'getAllCategories'],
    'POST'   => ['controller' => 'CategoryController', 'method' => 'createCategory'],
    'PUT'    => ['controller' => 'CategoryController', 'method' => 'updateCategory'],
    'DELETE' => ['controller' => 'CategoryController', 'method' => 'deleteCategories'],
    ],

];


if (isset($apis[$request])) {
    $controller_name = $apis[$request]['controller']; 
    $method = $apis[$request]['method'];
    require_once "controllers/{$controller_name}.php";

    $controller = new $controller_name();
    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        echo "Error: Method {$method} not found in {$controller_name}.";
    }
} else {
    echo "404 Not Found";
}