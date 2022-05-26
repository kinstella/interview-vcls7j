<?php

require __DIR__ . '/../vendor/autoload.php';

$twigLoader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($twigLoader);
$twig->addExtension(new \Twig\Extra\Intl\IntlExtension());
$db = require __DIR__ . '/../dbConnection.php';
$repository = new \Collegeplannerpro\InterviewReport\Repository($db);

$services = new \Collegeplannerpro\InterviewReport\NullableMemberLookup([
    'twig' => $twig,
    'repository' => $repository,
]);

$controller = new \Collegeplannerpro\InterviewReport\Controller($services);

$routes = [
    [
        'pattern' => '#^/reports/payments$#',
        'controller' => [$controller, 'paymentsReport'],
    ],
    [
        'pattern' => '#^/$#',
        'controller' => [$controller, 'home'],
    ],
    [
        'pattern' => '#^/contacts/(?<contactId>\d+)$#',
        'controller' => [$controller, 'contactDetails'],
    ],
];

$notFoundController = function () use ($services) {
    http_response_code(404);
    return $services->get('twig')->render('404.html.twig');
};
$router = new \Collegeplannerpro\InterviewReport\Router($routes, $notFoundController);

$parsedUrl = parse_url($_SERVER['REQUEST_URI']);
$path = $parsedUrl['path'];
$response = $router->resolve($path);

echo $response;
