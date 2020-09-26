<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate app
$app = AppFactory::create();

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader, 
//['cache' => '/path/to/compilation_cache',]
);

// Add Error Handling Middleware
$app->addErrorMiddleware(true, false, false);

// Add route callbacks
$app->get('/', function (Request $request, Response $response, array $args) use($twig){
    $response->getBody()->write($twig->render('index.twig',['title' => 'index', 'name' => 'Diego']));
    return $response;
});

$app->get('/child', function (Request $request, Response $response, array $args) use($twig){
    $response->getBody()->write($twig->render('index.twig',['title' => 'child', 'name' => 'Child']));
    return $response;
});

$app->get('/nested', function (Request $request, Response $response, array $args) use($twig){
    $array = [0 => ['name' => 'Diego', 'age' => 24, 'country' => 'Argentina'], 1 => ['name' => 'Pablo', 'age' => 21, 'country' => 'Italia']];
    $response->getBody()->write($twig->render('for.twig',['title' => 'for', 'people' => $array]));
    return $response;
});

// Run application
$app->run();